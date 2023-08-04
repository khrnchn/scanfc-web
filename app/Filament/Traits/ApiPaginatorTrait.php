<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ApiPaginatorTrait
{

    // Method	Description
    // $paginator->count()	Get the number of items for the current page.
    // $paginator->currentPage()	Get the current page number.
    // $paginator->firstItem()	Get the result number of the first item in the results.
    // $paginator->getOptions()	Get the paginator options.
    // $paginator->getUrlRange($start, $end)	Create a range of pagination URLs.
    // $paginator->hasPages()	Determine if there are enough items to split into multiple pages.
    // $paginator->hasMorePages()	Determine if there are more items in the data store.
    // $paginator->items()	Get the items for the current page.
    // $paginator->lastItem()	Get the result number of the last item in the results.
    // $paginator->lastPage()	Get the page number of the last available page. (Not available when using simplePaginate).
    // $paginator->nextPageUrl()	Get the URL for the next page.
    // $paginator->onFirstPage()	Determine if the paginator is on the first page.
    // $paginator->perPage()	The number of items to be shown per page.
    // $paginator->previousPageUrl()	Get the URL for the previous page.
    // $paginator->total()	Determine the total number of matching items in the data store. (Not available when using simplePaginate).
    // $paginator->url($page)	Get the URL for a given page number.
    // $paginator->getPageName()	Get the query string variable used to store the page.
    // $paginator->setPageName($name)	Set the query string variable used to store the page.


    function apiPaginator($data)
    {
        $paginateData = [];
        $paginateData['total'] = $data->total();
        $paginateData['count'] = $data->count();
        $paginateData['lastPage'] = $data->lastPage();
        $paginateData['perPage'] = $data->perPage();

        return $paginateData;
    }
}
