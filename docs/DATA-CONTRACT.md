# Contrato Web → n8n → CRM

Cada solicitud contiene:

- `folio`: identificador SGM-WEB.
- `source`: canal de origen.
- `received_at`: fecha UTC.
- `lead`: datos mínimos y consentimiento.
- `compliance`: estado SGM-COMPLIANCE-01 v1.2.

## Reglas

- No se aceptan documentos ni pagos en el primer formulario.
- Sin consentimiento no se crea registro.
- `null` significa dato todavía no determinado.
- `human_approval_required: false` permite revisión automática ordinaria.
- Una excepción legal, pago, queja o documento dudoso debe ir a cola humana.
- Si el registro no llega al CRM, no existe operativamente.
