# SGM–SAMS Web

Repositorio oficial del portal público de SGM–SAMS / SofIA Global Mobility para Licencias Internacionales, Membresías y Front Desk.

## Arquitectura

- `public_html/`: sitio publicable en SiteGround.
- `n8n/`: flujos exportables de automatización.
- `deployment/`: instrucciones de publicación y configuración segura.
- `docs/`: gobierno, cumplimiento y contratos de datos.

## Regla operativa

Entrada → Clasificación → Validación → CRM → Acción → Seguimiento → Cierre → Renovación.

Si no está en CRM, no existe operativamente.

## Seguridad

No almacenar secretos, contraseñas, tokens, datos personales ni documentos de clientes en GitHub. Las variables sensibles viven en SiteGround/n8n como secretos de entorno.
