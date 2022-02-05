<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\Style;

class Paginator extends Model
{
    protected $totalItems;
    protected $resultXpage;
    protected $cantPages;
    protected $pathInfo;
    protected $currentPage;

    public function __construct($collection, $resultXpage, $pathInfo, $currentPage)
    {
        $this->totalItems = count($collection);
        $this->resultXpage = (int)$resultXpage;
        $this->cantPages = ceil($this->totalItems / $resultXpage);
        $this->pathInfo = $pathInfo;
        if($currentPage == 0){
            $currentPage = 1;
        }
        if($currentPage > $this->cantPages){
            $currentPage = $this->cantPages;
        }
        $this->currentPage = $currentPage;
    }

    public function getGetResultXpageAttribute(){
       return $this->resultXpage;
    }
    public function getResultXpage(){
        return $this->resultXpage;
    }
    public function generateNav()
    {
        $ul = '<ul class="pagination">';
        $lis = '<li class="page-item">
        <a class="page-link text-dark" href="' . $this->pathInfo . '?page=' . ($this->currentPage - 1) . '" rel="prev" aria-label="' . ($this->currentPage - 1) .'"> < </a>
    </li>';
        for($i = 0; $i < $this->cantPages; $i++){
            if($i == ($this->currentPage - 1)){
                $lis = $lis . '<li class="page-item active">
                <b><a class="page-link bg-dark" href="' . $this->pathInfo . '?page=' . ($i + 1) . '" rel="prev" aria-label="' . $i .'">' . ($i + 1) . '</a></b>
            </li>';
            }else{
                $lis = $lis . '<li class="page-item">
                        <a class="page-link text-dark" href="' . $this->pathInfo . '?page=' . ($i + 1) . '" rel="prev" aria-label="' . $i .'">' . ($i + 1) . '</a>
                    </li>';
            }

        }
        $lis = $lis . '<li class="page-item">
        <a class="page-link text-dark" href="' . $this->pathInfo . '?page=' . ($this->currentPage + 1) . '" rel="prev" aria-label="' . ($this->currentPage + 1) .'"> > </a>
    </li>';
        $closeNav = '</ul>';
        return $ul . $lis . $closeNav;
    }
    public function skip(){
        return (($this->currentPage - 1) * $this->getResultXpage);
    }
}
