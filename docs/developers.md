# BuddyPress Followers Developer Documentation

## Table of Contents
1. [Plugin Architecture](#plugin-architecture)
2. [Core Functions](#core-functions)
3. [Hooks & Filters](#hooks--filters)
4. [REST API](#rest-api)
5. [Theming](#theming)

## Plugin Architecture

The plugin follows a modular architecture with these main components:

- **Core**: Handles initialization and setup
- **Component**: Main BuddyPress component integration
- **Activity**: Activity stream integration
- **Notifications**: Follow notifications system
- **API**: REST API endpoints

## Core Functions

### Main Functions

```php
// Start following a user
bp_follow_start_following([
    'leader_id' => 1,
    'follower_id' => 2
]);

// Stop following a user
bp_follow_stop_following([
    'leader_id' => 1,
    'follower_id' => 2
]);

// Check follow status
bp_is_following([
    'leader_id' => 1,
    'follower_id' => 2
]);

// Get followers count
bp_follow_get_followers_count(['user_id' => 1]);

// Get following count
bp_follow_get_following_count(['user_id' => 1]);
```

## Hooks & Filters

### Actions
- `bp_follow_start_following`: After a follow relationship is created
- `bp_follow_stop_following`: After a follow relationship is removed

### Filters
- `bp_follow_get_followers`: Modify followers query
- `bp_follow_get_following`: Modify following query

## REST API

Endpoints available at `/wp-json/buddypress/v1/follow`

### Methods
- `GET /`: List follow relationships
- `POST /`: Create new follow relationship
- `DELETE /{id}`: Remove follow relationship

## Theming

### Template Hierarchy

1. `members/single/follow.php`
2. `members/members-loop.php` (BuddyPress default)

Override templates by placing them in:
`your-theme/buddypress/members/single/follow.php`