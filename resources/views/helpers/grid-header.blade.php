<?php
if (!isset($helper_postfix)) {
    $helper_postfix = '';
    $dir_name = 'dir';
    $order_field_name = 'order_field';
} else {
    $helper_postfix = '_' . $helper_postfix;
    $dir_name = 'dir' . $helper_postfix;
    $order_field_name = 'order_field' . $helper_postfix;
}
$order_asc_param = Request::url() . '?order' . $helper_postfix . '=' . $order . '&dir' . $helper_postfix . '=ASC';
$order_desc_param = Request::url() . '?order' . $helper_postfix . '=' . $order . '&dir' . $helper_postfix . '=DESC';
$page_param = (isset($page) ? '&page' . $helper_postfix . '=' . $page : '');
$query_param = (isset($query) ? '&query' . $helper_postfix . '=' . $query : '');
?>
@if ($$dir_name == 'ASC')
    @if ($$order_field_name == $order)
        <a title="DESC" href="{{ $order_desc_param . $page_param }}">{{ $name }} <i class="fa fa-sort-desc"
                                                                                    aria-hidden="true"></i></a>
    @else
        <a title="DESC" href="{{ $order_desc_param . $page_param }}">{{ $name }}</a>
    @endif
@elseif ($$dir_name == 'DESC')
    @if ($$order_field_name == $order)
        <a title="ASC" href="{{ $order_asc_param . $page_param }}">{{ $name }} <i class="fa fa-sort-asc"
                                                                                  aria-hidden="true"></i></a>
    @else
        <a title="ASC" href="{{ $order_asc_param . $page_param }}">{{ $name }}</a>
    @endif
@else
    <a title="ASC" href="{{ $order_asc_param . $page_param }}">{{ $name }}</a>
@endif


