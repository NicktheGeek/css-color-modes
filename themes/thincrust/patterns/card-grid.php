<?php
/**
 * Title: Card Grid Query
 * Slug: thincrust/card-grid-query
 * Categories: query, thincrust
 * Viewport Width: 1200
 *
 * @package Thincrust
 */

?>
<!-- wp:query {"queryId":15,"query":{"perPage":"6","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"flex","columns":3},"className":"thincrust-card-grid-query"} -->
<div class="wp-block-query thincrust-card-grid-query"><!-- wp:post-template -->
<!-- wp:group {"backgroundColor":"blue","className":"has-white-color has-text-color"} -->
<div class="wp-block-group has-white-color has-text-color has-blue-background-color has-background"><!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:post-date {"isLink":true,"fontSize":"x-small"} /-->

<!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"large"} /-->

<!-- wp:post-excerpt {"moreText":""} /-->

<!-- wp:read-more {"content":"Read More","style":{"typography":{"textTransform":"uppercase"}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
