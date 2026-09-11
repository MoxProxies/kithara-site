<x-mail::message>
# New contact form message

**From:** {{ $name }} ({{ $email }})<br>
**Topic:** {{ $topic }}

---

{{ $body }}

---

Reply directly to this email to respond to {{ $name }}.
</x-mail::message>
