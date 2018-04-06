<?php
define('BUBLE_VERSION', '1.2.0 public-beta');
/*
 * Шаблонизатор Buble
 * Версия: 1.2.0
 * Автор: TheArtik
 * Личный сайт: https://as-code.ru
 */

class Buble
{
    public $viewName;

    public function __construct($viewName = '404')
    {
        $this -> viewName = $viewName;

        header('Powered-by: Buble ' . BUBLE_VERSION);
    }

    public static function templateName()
    {
        $db = Db::getConnection();
        $query = $db -> select('shop_settings', ['template']);
        return $query[0]['template'];
    }

    public static function dirlist($dir, $bool = "dirs"){
        $truedir = $dir;
        $dir = scandir($dir);
        if($bool == "files"){
            $direct = 'is_dir';
        }elseif($bool == "dirs"){
            $direct = 'is_file';
        }
        foreach($dir as $k => $v){
            if(($direct($truedir.$dir[$k])) || $dir[$k] == '.' || $dir[$k] == '..' ){
                unset($dir[$k]);
            }
        }
        $dir = array_values($dir);
        return $dir;
    }

    public static function getTemplates()
    {
        $folders = Buble::dirlist(APPPATH . '/templates/');
        $current = Buble::templateName();
        $templates = array();
        for ($i = 0; $i <= count($folders); $i++)
        {
            if (file_exists(APPPATH . '/templates/' . $folders[$i] . '/info.ctp')) {
                $temp = parse_ini_file(APPPATH . '/templates/' . $folders[$i] . '/info.ctp');
                foreach ($temp as $key => $val) {
                    $temp[$key] = htmlspecialchars($val);
                }
                $templates[$i] = $temp;
                $templates[$i]['name'] = $folders[$i];
                $templates[$i]['active'] = ($current == $folders[$i]);
            }
        }
        return $templates;
    }

    public static function getTeplateSettings ()
    {
        $info_file = APPPATH . '/templates/' .Buble::templateName(). '/info.ctp';
        $sett = parse_ini_file($info_file);
        $sett['name'] = Buble::templateName();
        return $sett;
    }

    public static function changeTemplate($template)
    {
        $templates = Buble::getTemplates();

        $exists = false;

        foreach ($templates as $tpl)
        {
            if ($tpl['name'] === $template) {
                $exists = true;
            }
        }

        if ($exists === true) {
            $db = Db::getConnection();
            $query = $db -> update('shop_settings', [
                'template' => $template
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function processView($emptyView, $viewName, $data = [], $template) {
        $lines = explode("\n", $emptyView);
        foreach ($lines as $line) {
            if (strpos($line, '{') !== false) {
                if (preg_match_all('/{(.*?)}/', $line, $matches)) {
                    foreach ($matches[1] as $match) {
                        if ($match[0] == '$') $match = substr($match, 1, strlen($match)-1);

                        if (isset($data[$match])) {
                            $emptyView = str_replace('{$'.$match.'}', $data[$match], $emptyView);
                        } else {
                            if (preg_match_all('/import \"(.*?)\"/', $match, $importMatches)) {
                                if (file_exists(APPPATH . '/templates/'.$template.'/views/' . $importMatches[1][0] . '.tpl')) {
                                    $importView = file_get_contents(APPPATH . '/templates/'.$template.'/views/' . $importMatches[1][0] . '.tpl');
                                    $importView = $this->processView($importView, '', $data, $template);
                                    $emptyView = str_replace('{import "'.$importMatches[1][0].'"}', $importView, $emptyView);
                                } else {
                                    die('Buble error. File ' . '/views/' . $importMatches[1][0] . '.tpl was not found');
                                }
                            } else {
                                if (preg_match_all('/content/', $match, $contentMatches)) {
                                    if (file_exists(APPPATH . '/templates/'.$template.'/views/' . $viewName . '.tpl')) {
                                        $importView = file_get_contents(APPPATH . '/templates/'.$template.'/views/' . $viewName . '.tpl');
                                        $importView = $this->processView($importView, '', $data, $template);
                                        $emptyView = str_replace('{content}', $importView, $emptyView);
                                    } else {
                                        die('Buble error. File ' . '/views/' . $viewName . '.tpl was not found');
                                    }
                                } else {
									if (preg_match_all('/foreach:(\d{1,2}) \$(\w{1,16})/', $match, $foreachMatches)) {
										$id = $foreachMatches[1][0];
										$variable = $foreachMatches[2][0];

										if (isset($data[$variable])) {
										    preg_match('/{foreach:'.$id.' \$'.$variable.'}((.|\n)*){endforeach:'.$id.'}/', $emptyView, $foreachInnerAll);
										    $foreachInner = $foreachInnerAll[1];
										    preg_match_all('/foreach:'.$id.'\["(\w*)"\]/', $foreachInner, $foreachInnerMatches);
										    $newInput = [];
										    foreach ($data[$variable] as $i => $forItem) {
                                                $newInput[$i] = $foreachInner;
                                                foreach ($foreachInnerMatches[1] as $item) {
                                                    $newInput[$i] = str_replace('{foreach:'.$id.'["'.$item.'"]}', $forItem[$item], $newInput[$i]);
                                                }
                                            }
                                            $emptyView = str_replace($foreachInnerAll[0], implode("\n", $newInput), $emptyView);
                                        }
									}
								}
                            }
                        }
                    }
                }
            }
        }

        $view = $emptyView;
        return $view;
    }

    public function minifyOutput($buffer) {
        $search = [
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        ];
        $replace = [
            '>',
            '<',
            '\\1',
            ''
        ];

        if (MINIFY_OUTPUT) {
            $buffer = preg_replace($search, $replace, $buffer);
        }

        return $buffer;
    }

    public function createView($data)
    {
        $viewName = $this -> viewName;
        ob_start();
        $template = Buble::templateName();
        include_once(APPPATH . '/templates/'.$template.'/views/emptyView.php');
        $buffer = ob_get_clean();
        header('X-Request-Time: ' . (microtime(true)-B_START));
        echo $this->minifyOutput($buffer);
    }
}