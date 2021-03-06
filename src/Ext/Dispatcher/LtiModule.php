<?php
/*
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2007 Michael Mifsud
 */
namespace Ext\Dispatcher;

/**
 * Module Dispatcher
 *
 *
 *
 */
class LtiModule extends \Tk\Object implements \Tk\Dispatcher\Iface
{

    /**
     * Use this method to create and return the module class name
     *
     * @param \Tk\Dispatcher\Dispatcher $obs
     */
    public function update($obs)
    {
        if ($obs->getClass()) {
            return;
        }

        $path = $this->getUri()->getPath(true);
        $path = str_replace(array('./', '../'), '', $path);
        if (!preg_match('/\.([a-z0-9_-]{2,4})$/i', $path)) {
            $path .= '/index.html';
        }
        if (preg_match('/^lti\/([a-z0-9_\/\-]+)*(\.(\S+))/i', trim($path, '/'), $regs)) {
            $arr = explode('/', $regs[1]);
            foreach ($arr as $i => $v)  $arr[$i] = ucfirst($v);
            array_unshift($arr, 'Lti');
            array_unshift($arr, 'Ext');
            $class = implode('\\', $arr);
            $output = $regs[3];
            if ($class && class_exists($class)) {
                $obs->setClass($class);
                $obs->setOutput($output);
            }
        }
    }
}
