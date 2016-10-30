<?php
$order_asc_param = Request::url().'?order='.$order.'&dir=ASC';
$order_desc_param = Request::url().'?order='.$order.'&dir=DESC';
$page_param = (isset($page) ? '&page='.$page : '');
$query_param = (isset($query) ? '&query='.$query : '');
?>
@if ($dir == 'ASC')
    @if ($order_field == $order)
        <a title="DESC" href="{{ $order_desc_param.$page_param }}">{{ $name }} <i class="fa fa-sort-desc" aria-hidden="true"></i></a>
    @else
        <a title="DESC" href="{{ $order_desc_param.$page_param }}">{{ $name }}</a>
    @endif
@elseif ($dir == 'DESC')
    @if ($order_field == $order)
        <a title="ASC" href="{{ $order_asc_param.$page_param }}">{{ $name }} <i class="fa fa-sort-asc" aria-hidden="true"></i></a>
    @else
        <a title="ASC" href="{{ $order_asc_param.$page_param }}">{{ $name }}</a>
    @endif
@else
    <a title="ASC" href="{{ $order_asc_param.$page_param }}">{{ $name }}</a>
@endif


