<!--Pagination--> 
@if(!empty($pagination['count']) && $pagination['count'] > 1)
<div class="text-center">

    <ul class="pagination">
        @if($pagination['active'] != 1)
        <li>
            <a href="{{$pagination['url'] .'1' }}"><span>&laquo;</span></span></a>
        </li>
        <li>
            <a href="{{$pagination['url'] . ($pagination['active'] - 1) }}"><span>&lsaquo;</span></span></a>
        </li>
        @endif
        @if ($pagination['active'])

        @if ($pagination['active'] < 3)
        @for($i = 1, $end = (($pagination['count'] > 5)? 5 : $pagination['count']); $i <= $end ; $i++)
        <li @if($i == $pagination['active'])class="active"@endif>
             <a href="{{$pagination['url'].$i}}">{{$i}}</a>
        </li>
        @endfor
        @elseif($pagination['active'] >= ($pagination['count'] - 2) )
        <a href="pagination.blade.php"></a>
        @for($i = ($pagination['count'] - 5 > 0)? $pagination['count'] - 5 :1; $i <= $pagination['count'] ; $i++)
        <li @if($i == $pagination['active'])class="active"@endif>
             <a href="{{$pagination['url'].$i}}">{{$i}}</a>
        </li>
        @endfor
        @else
        @for($i = $pagination['active'] - 2,$end = $pagination['active'] + 2; $i <= $end ; $i++)
        <li @if($i == $pagination['active'])class="active"@endif>
             <a href="{{$pagination['url'].$i}}">{{$i}}</a>
        </li>
        @endfor
        @endif
        @endif
        @if($pagination['count'] != $pagination['active'])
        <li>
            <a href="{{$pagination['url'] . ($pagination['active'] + 1)}}"><span>&rsaquo;</span></a>
        </li>
        <li>
            <a href="{{$pagination['url'] .($pagination['count'])}}"><span>&raquo;</span></a>
        </li>
        @endif
    </ul>
</div>
@endif

<!--End Pagination--> 