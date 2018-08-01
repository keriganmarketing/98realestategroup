<?php

namespace Includes\Modules\MLS;

use GuzzleHttp\Client;

class QuickSearch
{
    protected $approvedParams;
    protected $searchRequested;
    protected $searchParams;
    protected $searchResults;
    protected $formattedRequest;

    /**
     * QuickSearch constructor.
     * configure any options here
     */
    public function __construct ()
    {
        $this->approvedParams = [
            'omni',
            'area',
            'status',
            'propertyType',
            'forclosure',
            'minPrice',
            'maxPrice',
            'beds',
            'baths',
            'sqft',
            'acreage',
            'waterfront',
            'waterview',
            'sort',
            'page'
        ];
        $this->searchParams = [];
        $this->searchResults = [];
        $this->searchRequested = (isset($_GET['q']) && $_GET['q'] == 'search' ? $_GET : null);

        if(!$this->searchRequested){
            $this->searchParams = [
                'area' => 'Mexico Beach',
                'minPrice' => 200000,
                'status'   => ['Active']
            ];
        }

        $this->contactTheMothership();

    }

    public function getSearchResults()
    {
        return $this->searchResults;
    }

    public function getResultMeta()
    {
        return isset($this->searchResults->meta->pagination) ? $this->searchResults->meta->pagination : null;
    }

    public function getCurrentRequest()
    {
        return json_encode($this->searchParams);
    }

    public function getSort()
    {
        return isset($this->searchRequested['sort']) ? $this->searchRequested['sort'] : 'price|desc';
    }

    public function filterRequest()
    {
        foreach($_GET as $key => $var){
            if(in_array($key, $this->approvedParams)){
                $this->searchParams[$key] = $var;
            }
        }
    }

    public function makeRequest()
    {
        $this->filterRequest();

        $request = '?q=search';
        foreach($this->searchParams as $key => $var){
            if(is_array($var)){
                $request .= '&' . $key . '=';
                $i = 1;
                foreach($var as $k => $v){
                    $request .= $v . ($i < count($var) ? '|' : '');
                    $i++;
                }
            }else{
                if($var != '' && $var != 'Any'){
                    $request .= '&' . $key . '=' . $var;
                }
            }
        }

        $this->$formattedRequest = $request;

        return $request . '&page=' . get_query_var( 'page' );
    }

    public function contactTheMothership()
    {
        $client     = new Client(['base_uri' => 'https://rafgc.kerigan.com/api/v1/']);
        $apiCall = $client->request(
            'GET', 'search' . $this->makeRequest() . '&page=' . get_query_var( 'page' )
        );

        $this->searchResults = json_decode($apiCall->getBody());
    }

    public function buildPagination()
    {
        $pages = $this->getResultMeta();
        $request = $wp->request . $this->$formattedRequest;
        $currentPage = $pages->current_page;

        echo '<nav aria-label="search results pagination"><ul class="pagination">';
        if(isset($pages->links->previous)){
            $link = $request . '&page=' . ($currentPage - 1);
            echo '<li class="page-item"><a class="page-link" href="'. $link .'" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a></li>';
        }else{
            echo '<li class="page-item disabled"><a class="page-link disabled" tabindex="-1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a></li>';
        }

        if($pages->total_pages >= 5){
            $startPage = ($currentPage > 2 ? $currentPage - 2 : 1 );
            $endPage   = ($currentPage < $pages->total_pages - 2 ? $currentPage + 2 : $pages->total_pages );

            for($i = $startPage; $i <= $endPage; $i++){
                $link = $request . '&page=' . $i;
                echo '<li class="page-item' . ($currentPage == $i ? ' active' : '') . '"><a class="page-link" href="'. $link .'">' . $i .'</a></li>';
            }

            if($endPage < $pages->total_pages - 3){
                echo '<li class="page-item disabled"><a class="page-link disabled" tabindex="-1" >...</a></li>';
                echo '<li class="page-item"><a class="page-link" href="'. $request . '&page=' . $pages->total_pages .'">'. $pages->total_pages .'</a></li>';
            }
        }

        if(isset($pages->links->next)){
            $link = $request . '&page=' . ($currentPage + 1);
            echo '<li class="page-item"><a class="page-link" href="'. $link .'" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a></li>';
        }else{
            echo '<li class="page-item disabled"><a class="page-link disabled" tabindex="-1" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a></li>';
        }
        
        echo '</ul></nav>';

    }
}