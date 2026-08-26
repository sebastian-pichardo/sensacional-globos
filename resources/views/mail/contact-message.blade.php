<x-mail::message>
# Nuevo mensaje de contacto

Recibiste un mensaje desde el formulario de Globos Sensacionales.

**Nombre:** {{ $contactMessage->name }}
**Correo electrónico:** {{ $contactMessage->email }}
**Teléfono:** {{ $contactMessage->phone }}
**Empresa:** {{ $contactMessage->company ?: '—' }}
**Estado:** {{ $contactMessage->state }}

**Mensaje:**
{{ $contactMessage->message }}
</x-mail::message>
