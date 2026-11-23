{{-- Priority queue confirmation: same page as the normal one, shown in the priority style. --}}
@include('patient.NQ_confirmation', ['isPriority' => true, 'queueNumber' => $queueNumber ?? 'P--'])
