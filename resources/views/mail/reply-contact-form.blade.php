# Réponse à votre message de contact

Bonjour {{ $contact->nom }},

Merci de nous avoir contactés. Voici la réponse de notre équipe :

---

{{ $contact->reponse }}

---

**Informations du message initial :**

| Champ | Valeur |
| --- | --- |
| **Sujet** | {{ $contact->sujet }} |
| **Type de demande** | {{ $contact->type_demande }} |
| **Reçu le** | {{ $contact->created_at->format('d/m/Y à H:i') }} |
| **Répondu le** | {{ $contact->reponse_date->format('d/m/Y à H:i') }} |

Si vous avez d'autres questions, n'hésitez pas à nous contacter à nouveau.

---

*Merci de votre confiance en Flux !*
