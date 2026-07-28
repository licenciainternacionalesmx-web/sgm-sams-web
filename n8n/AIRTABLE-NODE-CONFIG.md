# Nodo Airtable — SGM_WEB_LEAD_COMPLIANCE_V1

El nodo **Crear expediente en Airtable** ya apunta a:

- Base: **SGM-SAMS CORE** (`appEYY7jkfaZHWExU`)
- Tabla: **Expedientes Clientes SGM–SAMS** (`tbl6cPc3yjbFLkoqp`)

## Mapeo activo

Folio, nombre, correo, WhatsApp, consentimiento, fecha de solicitud, fuente web y un bloque de notas con servicio, destino, mensaje y estado de cumplimiento.

## Único paso privado pendiente

Dentro de n8n, seleccionar una credencial Airtable con permiso para crear registros en esa base. El token no debe escribirse en GitHub ni pegarse en conversaciones.

## Prueba controlada

Mantener el workflow inactivo. Ejecutar una solicitud ficticia y confirmar:

1. folio SGM-WEB;
2. creación de un solo expediente;
3. devolución de `airtable_record_id`;
4. `compliance_status=pending_review`;
5. `operational_state=registered_in_crm`.

Activar el workflow solo después de esos cinco resultados.
