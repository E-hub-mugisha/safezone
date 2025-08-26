@component('mail::message')
# {{ $isStaff ? 'New Case Reported' : 'Case Submission Confirmation' }}

@if($isStaff)
A new case has been submitted:

- **Case Number**: {{ $case->case_number }}
- **Type**: {{ ucfirst($case->type) }}
- **Survivor Name**: {{ $case->survivor_name }}
- **Location**: {{ $case->location ?? 'N/A' }}

Please log in to review and take action.
@else
Dear {{ $case->survivor_name }},

Thank you for submitting your case.  
Your case has been successfully recorded.

- **Case Number**: {{ $case->case_number }}
- **Type**: {{ ucfirst($case->type) }}
- **Description**: {{ $case->description }}

We will keep you updated on the progress.
@endif

Thanks,  
**SafeZone Team**
@endcomponent
