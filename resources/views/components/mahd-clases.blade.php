<ul>
    @foreach($rows as $row)
        <li><a href="/planes/rollcall/{{$row->id}}">{{$row->name}} - ({{$row->plane->title}})</a></li>
    @endforeach
</ul>
