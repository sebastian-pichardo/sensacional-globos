<x-mail::message>
# Nueva inscripción en Inspírate

Alguien se inscribió al programa de decoradores Sensacional.

**Nombre:** {{ $application->name }}
**Correo electrónico:** {{ $application->email }}
**WhatsApp:** {{ $application->whatsapp }}
**Ciudad o estado:** {{ $application->city_or_state }}
**Redes sociales:** {{ $application->social_networks ?: '—' }}
**Acepta promociones:** {{ $application->accept_promotions ? 'Sí' : 'No' }}

**¿Por qué te gustaría ser decorador sensacional?**
{{ $application->motivation }}
</x-mail::message>
