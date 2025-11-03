<?php

if (!function_exists('embed_url')) {
  function embed_url(string $url): string
  {
    $host = strtolower(parse_url($url, PHP_URL_HOST) ?: '');
    if (str_contains($host, 'youtu.be')) {
      // youtu.be/VIDEOID
      $id = trim(parse_url($url, PHP_URL_PATH) ?? '/', '/');
      return "https://www.youtube.com/embed/{$id}";
    }
    if (str_contains($host, 'youtube.com')) {
      parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $q);
      if (!empty($q['v'])) return "https://www.youtube.com/embed/{$q['v']}";
    }
    if (str_contains($host, 'vimeo.com')) {
      $id = preg_replace('~^/~', '', parse_url($url, PHP_URL_PATH) ?? '');
      return "https://player.vimeo.com/video/{$id}";
    }
    return $url; // fallback
  }
}
