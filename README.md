# steelers-de-theme

## after push

prod cache clear in contao manager


API Dokumentation: https://gamestatsdelclubs.docs.apiary.io/
API: https://s3-eu-west-1.amazonaws.com/de.hokejovyzapis.cz/league-team-matches/2022/1/22.json


Query to get news from wordpress with image
```
SELECT `wp_posts`.`post_content`, wp_posts.post_title, wp_posts.post_name, jfj.guid FROM `wp_posts` LEFT JOIN ( SELECT `wp_postmeta`.`post_id`, `wp_posts`.`guid` FROM `wp_postmeta` LEFT JOIN `wp_posts` ON (`wp_postmeta`.`meta_value` = `wp_posts`.`ID`) WHERE meta_key = '_thumbnail_id') as jfj ON jfj.post_id = `wp_posts`.ID WHERE post_status = 'publish' AND post_type = 'post' ORDER BY `wp_posts`.`post_date` DESC;
```
