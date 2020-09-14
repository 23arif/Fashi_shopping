@component('mail::message')
<span style="font-weight: bold">Name :</span> {{$data['name']}}<br>
<span style="font-weight: bold">Email :</span>  {{$data['email']}}<br>
<span style="font-weight: bold">Message :</span><br>  {{$data['message']}}<br>

Thanks,
{{ config('app.name') }}<br>
{{ now() }}
@endcomponent
