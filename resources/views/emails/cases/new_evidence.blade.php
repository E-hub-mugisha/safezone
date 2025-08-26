@component('mail::message')
# New Evidence Added  

New evidence has been uploaded for **Case ID: {{ $case->case_number }}**.  

### Case Details:
- Survivor Name: {{ $case->survivor_name }}
- Case Type: {{ ucfirst($case->type) }}
- Status: {{ ucfirst($case->status) }}

@component('mail::button', ['url' => url('/cases/'.$case->id)])
View Case
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
