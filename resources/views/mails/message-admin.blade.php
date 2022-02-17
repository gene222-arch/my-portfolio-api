@component('mail::message')
# Introduction

Good day! Mr. Gene Phillip Artista,

@component('mail::panel')
{{ $messageContent }}
@endcomponent

Thanks,<br>
{{ $name }}
@endcomponent
