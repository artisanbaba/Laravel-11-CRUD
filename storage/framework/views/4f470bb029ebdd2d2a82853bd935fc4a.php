

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-dark mb-3">← Back to Products</a>

            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h3>Product Details</h3>
                </div>

                <div class="card-body">

                    <?php if($product->image): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo e(asset('uploads/products/' . $product->image)); ?>" 
                                 width="200" 
                                 class="img-thumbnail">
                        </div>
                    <?php endif; ?>

                    <h4>Name: <?php echo e($product->name); ?></h4>
                    <p><strong>SKU:</strong> <?php echo e($product->sku); ?></p>
                    <p><strong>Price:</strong> $<?php echo e($product->price); ?></p>
                    <p><strong>Description:</strong> <?php echo e($product->description); ?></p>

                    <p><strong>Created At:</strong> 
                        <?php echo e(\Carbon\Carbon::parse($product->created_at)->format('d M, Y')); ?>

                    </p>

                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-dark">Edit</a>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Rohit\Downloads\laravel11-crud\resources\views/products/show.blade.php ENDPATH**/ ?>