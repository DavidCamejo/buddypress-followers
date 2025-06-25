# BuddyPress Followers (Refactorizado)

[![License: GPL v2](https://img.shields.io/badge/License-GPL_v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![PHP Version Required](https://img.shields.io/badge/PHP-%3E%3D8.0-8892BF.svg)](https://php.net/)
[![BuddyPress Version Required](https://img.shields.io/badge/BuddyPress-%3E%3D12.0-1a85ce.svg)](https://buddypress.org/)

Una versión moderna y refactorizada del plugin BuddyPress Followers, compatible con las últimas versiones de WordPress, BuddyPress y PHP.

## Características principales

- ✅ Sistema de seguimiento entre usuarios
- ✅ Notificaciones en tiempo real
- ✅ Integración con el stream de actividad
- ✅ REST API completamente funcional
- ✅ Soporte para bloques de Gutenberg
- ✅ Internacionalización completa
- ✅ Alto rendimiento con sistema de caché
- ✅ Compatibilidad con PHP 8.0+ y WordPress 6.4+

## Instalación

1. Descarga el [último release](https://github.com/DavidCamejo/buddypress-followers/releases)
2. Sube el ZIP a tu sitio WordPress en `Plugins > Añadir nuevo > Subir plugin`
3. Activa el plugin
4. Configura los ajustes en `Ajustes > BuddyPress > Followers`

O clona el repositorio directamente en tu carpeta de plugins:

git clone https://github.com/DavidCamejo/buddypress-followers.git

## Requisitos del sistema

- WordPress 6.4+

- BuddyPress 12.0+

- PHP 8.0+

- MySQL 5.7+ o MariaDB 10.3+

## Documentación para desarrolladores

### Estructura del proyecto

```
buddypress-followers/
├── assets/          # Assets compilados (JS/CSS)
├── includes/        # Lógica principal del plugin
├── languages/       # Archivos de traducción
├── templates/       # Plantillas personalizables
├── tests/           # Pruebas unitarias
├── vendor/          # Dependencias de Composer
├── composer.json    # Configuración de Composer
└── buddypress-followers.php # Archivo principal
```

### Hooks disponibles

#### Acciones

- `bp_follow_start_following` - Cuando un usuario comienza a seguir a otro

- `bp_follow_stop_following` - Cuando un usuario deja de seguir a otro

#### Filtros

- `bp_follow_get_followers` - Modifica la consulta de seguidores

- `bp_follow_get_following` - Modifica la consulta de seguidos

### API REST

Endpoints disponibles:

- `GET /wp-json/buddypress/v1/follow` - Listar relaciones

- `POST /wp-json/buddypress/v1/follow` - Crear relación

- `DELETE /wp-json/buddypress/v1/follow/{id}` - Eliminar relación

### Personalización de plantillas

Para sobrescribir plantillas, copia los archivos de `templates/` a:

`your-theme/buddypress/members/single/`

## Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Haz fork del repositorio

2. Crea una rama (`git checkout -b feature/mejora`)

3. Haz commit de tus cambios (`git commit -am 'Añade alguna mejora'`)

4. Haz push a la rama (`git push origin feature/mejora`)

5. Abre un Pull Request

## Licencia

GPL-2.0+. Ver [LICENSE](https://LICENSE) para más detalles.
