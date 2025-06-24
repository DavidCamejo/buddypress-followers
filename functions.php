// Ejemplo de función modificada para usar caché
function bp_follow_get_followers($args = []) {
    $r = wp_parse_args($args, [
        'user_id' => bp_displayed_user_id(),
    ]);
    
    // Intentar obtener de caché primero
    $cached = Cache::get_followers($r['user_id']);
    if (false !== $cached) {
        return $cached;
    }
    
    // Consulta a la base de datos si no está en caché
    global $wpdb;
    $bp = buddypress();
    
    $followers = $wpdb->get_col($wpdb->prepare(
        "SELECT follower_id FROM {$bp->follow->table_name} WHERE leader_id = %d",
        $r['user_id']
    ));
    
    // Almacenar en caché
    Cache::set_followers($r['user_id'], $followers);
    
    return $followers;
}