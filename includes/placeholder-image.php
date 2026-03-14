<?php
/**
 * Reusable image placeholder for sections that will have images later.
 * Usage: include with optional $placeholder_label and $placeholder_aspect set before include.
 * @var string $placeholder_label   Optional. Label shown in the box (default: "Image placeholder").
 * @var string $placeholder_aspect  Optional. Tailwind aspect class (default: "aspect-video").
 */
if (!isset($placeholder_label)) {
    $placeholder_label = 'Image placeholder';
}
if (!isset($placeholder_aspect)) {
    $placeholder_aspect = 'aspect-video';
}
?>
<div class="placeholder-image <?php echo htmlspecialchars($placeholder_aspect); ?> bg-neutral-800 border border-neutral-700 rounded-xl flex items-center justify-center text-neutral-500 text-sm">
    <?php echo htmlspecialchars($placeholder_label); ?>
</div>
