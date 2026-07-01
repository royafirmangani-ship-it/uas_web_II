<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <?php foreach ($breadcrumb as $crumb): ?>
                            <?php if (isset($crumb['url'])): ?>
                                <li class="breadcrumb-item"><a href="<?= site_url($crumb['url']) ?>"><?= $crumb['label'] ?></a></li>
                            <?php else: ?>
                                <li class="breadcrumb-item active"><?= $crumb['label'] ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?= $content ?>
        </div>
    </div>
</div>
