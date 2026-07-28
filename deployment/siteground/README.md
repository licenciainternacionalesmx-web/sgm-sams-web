# Publicación segura en SiteGround

## Destino

Dominio: `licenciasinternacionales.com.mx`
Carpeta pública: `public_html/`

## Antes de publicar

1. Crear respaldo completo del `public_html` actual.
2. Probar esta versión en una carpeta o subdominio separado.
3. Confirmar teléfonos, precios, textos legales e imágenes autorizadas.
4. No subir archivos `.env`, tokens, contraseñas, bases de datos ni documentos de clientes.

## Configuración privada

Crear en SiteGround una variable de entorno PHP:

```text
SGM_N8N_LEAD_WEBHOOK=https://TU-N8N/webhook/sgm-web-lead-v1
```

La URL real no debe guardarse en GitHub ni mostrarse en el navegador.

## n8n

1. Importar `n8n/workflows/SGM_WEB_LEAD_COMPLIANCE_V1.json`.
2. Conectar el nodo **Puente CRM — configurar Airtable** con credenciales privadas.
3. Mapear el folio y los datos a Airtable CRM SGM–SAMS | SofIA Ventas.
4. Activar el workflow solamente después de una prueba controlada.
5. Copiar la URL de producción del webhook a `SGM_N8N_LEAD_WEBHOOK` en SiteGround.

## Estados

`captured → classified → pending_review → CRM → action`

La publicación de contenido comercial permanece bloqueada mientras `publication_allowed` sea `false`.
