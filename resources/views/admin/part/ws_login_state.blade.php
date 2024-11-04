<div class="container">
    <strong>
        <h2>Login History Log</h2>
    </strong>
    <hr>
    <table class="table table-bordered table-striped" width="100%" border="0" cellspacing="1" cellpadding="1"
        style="font-family:Tahoma, Geneva, sans-serif; font-size:15px">
        <thead bgcolor="#ffb894">
            <tr>
                <th width="7%"><strong><span class="style1">seq</span></strong></th>
                <th width="26%"><strong><span class="style1">identify</span></strong></th>
                <th width="33%"><strong><span class="style1">access date</span></strong></th>
                <th width="34%"><strong>Ip Address</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logon_detail as $row)
            <tr>
                <td>{{ $row->seq }}</td>
                <td>{{ $row->identify }}</td>
                <td>{{ $row->access_date }}</td>
                <td>{{ $row->ip_address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
