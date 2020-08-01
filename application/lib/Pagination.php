<?php

namespace Beejee\application\lib;

use Beejee\application\core\View;

class Pagination
{
    private $max = 3;
    private $route;
    private $amount;
    private $current_page;
    private $total;
    private $limit;

    public function __construct($route, $total, $limit = 3)
    {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }

    public function get()
    {
        $links = null;
        $limits = $this->limits();
        $html = '<nav><ul class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="page-item active"><span class="page-link">' . $page . '</span></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generateHtml(1, '<<') . $links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->amount, '>>');
            }
        }
        $html .= $links . ' </ul></nav>';
        return $html;
    }

    private function generateHtml($page, $text = null)
    {
        if (!$text) {
            $text = $page;
        }

        $parts = parse_url($_SERVER['REQUEST_URI']) + array('query' => array());

        $query = '';

        if (isset($parts['query']) && !empty($parts['query']) != '') {
            parse_str($parts['query'], $query);
            if (!empty($query)) {
                $query = '?' . http_build_query(array_merge($query, array('page' => $page)));
            }
        } else {
            $query = '?page=' . $page;
        }

        $link = $parts['path'] . $query;

        return '<li class="page-item"><a class="page-link" href="' . $link . '">' . $text . '</a></li>';
    }

    private function limits()
    {
        $left = $this->current_page - round($this->max / 3);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    private function setCurrentPage()
    {
        if (!isset($this->route) || !is_numeric($this->route) || $this->route < 0) {
            $currentPage = 1;
        } else {
            $currentPage = $this->route;
        }
        $this->current_page = $currentPage;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    private function amount()
    {
        return ceil($this->total / $this->limit);
    }
}