<?php
?>

<div class="header">
    <h2><?php esc_attr_e( 'Products', 'WpAdminStyle' ); ?></h2>
</div>


<div class="container">
	<div class="card workflow">
		<div class="content">
			<div class="head">
                <div class="title">
                    <h2>Create your workflow</h2>
                </div>
                <div class="icon">
                    <a href="#" class="add">
                        <svg style="height: 24px; width: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="new_items">

            </div>
			<div class="flex">
				<div class="select_box">
					<p><strong>When user purchase this product</strong></p>
                    <select class="product" style="width:100%"> </select>
				</div>

				<div class="select_box">
					<p><strong>These courses will be assigned to user</strong></p>
                    <select class="courses" multiple="multiple" style="width:100%"> </select>
				</div>
                <div class="delete_icon">
                    <a href="#" class="delete-row">
                        <svg style="height: 24px; width: 24px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
			</div>
			<?
			while ( $this->products->have_posts() ) : $this->products->the_post();
				global $product;
				?>
                <div class="flex">
                    <div class="select_box">
                        <p><strong>When user purchase this product</strong></p>
                        <select data-init='{"id": <?php echo get_the_ID()?>, "title": "<?php echo get_the_title(); ?>"}' class="product" style="width:100%"> </select>
                    </div>

                    <div class="select_box">
                        <p><strong>These courses will be assigned to user</strong></p>
                        <select data-init='<?php echo json_encode(get_post_meta(get_the_ID(), "courses", true)) ?>' class="courses" multiple="multiple" style="width:100%"> </select>
                    </div>
                    <div class="delete_icon">
                        <a href="#" class="delete-row">
                            <svg style="height: 24px; width: 24px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
			<? endwhile; ?>
		</div>
	</div>


</div>

<script>
    jQuery(function ($) {
        initializeSelect2($('body'))
        function initializeSelect2(parent) {

            $(parent).find('.product').select2({
                placeholder: "Search for product",
                ajax: {
                    url: ajaxurl,
                    type: 'GET',
                    contentType: 'application/json',
                    data: function (params) {
                        return {
                            term: params.term,
                            action: 'woocommerce_json_search_products_and_variations',
                            security: "<?php echo wp_create_nonce( 'search-products' ); ?>"
                        };
                    },
                    processResults: function (data) {
                        let terms = [];
                        if (data) {
                            $.each(data, function (id, text) {
                                terms.push({id: id, text: text});
                            });
                        }
                        return {results: terms};
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            $(parent).find('.product').trigger('change').trigger({
                type: 'select2:select',
                params: {
                    data: {"id" : 1, text: "hello"}
                }
            });

            $(parent).find('.courses').select2({
                placeholder: "Search for course",
                ajax: {
                    url: ajaxurl,
                    action: 'mishagetposts',
                    type: 'GET',
                    contentType: 'application/json',
                    data: function (params) {
                        return {
                            q: params.term,
                            action: 'mishagetposts'
                        };
                    },
                    processResults: function (data) {
                        var options = [];
                        if (data) {
                            $.each(data.results, function (index, text) {
                                options.push({id: text.id, text: text.title});
                            });
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            $(parent).find('.product').each(function(i, el) {
                var initial_data = $(el).data("init")
                if (initial_data) {
                    $(el).append($("<option/>", {
                        value: initial_data.id,
                        text: initial_data["title"],
                        selected: true
                    }));
                }
            });

            $(parent).find('.courses').each(function(i, el) {
                let initial_data = $(el).data("init") || []
                if (Array.isArray(initial_data) ) {
                    initial_data.forEach((data)=>{
                        $(el).append($("<option/>", {
                            value: data.id,
                            text: data.title,
                            selected: true
                        }));
                    })
                }
            });

            $(parent).find('.product').on('select2:select', function (e) {
                var data = e.params.data;
                let courses = $(e.target).parent().siblings().find('.courses').select2('data');
                if (courses.length) {
                    savePostData(data.id, courses)
                }

            });

            $(parent).find('.product').on('select2:selecting', function (e) {
                var data = $(e.target).select2('data');
                let courses = $(e.target).parent().siblings().find('.courses').select2('data');
                if (data.length && courses.length) {
                    deletePostData(data[0].id)
                }
            });

            $(parent).find('.courses').on('select2:select', function (e) {
                var data = $(e.target).select2('data');
                let product = $(e.target).parent().siblings().find('.product').select2('data');
                if (product.length && data.length) {
                    savePostData(product[0].id, data)
                }
            });

            $(parent).find('.courses').on('select2:unselect', function (e) {
                var data = $(e.target).select2('data');
                let product = $(e.target).parent().siblings().find('.product').select2('data');
                if (product.length) {
                    savePostData(product[0].id, data)
                }
            });
        }



        function savePostData(post_id, data) {
            let selected_courses = []
            data.forEach(function (data) {
                selected_courses.push({id: data.id, title: data.text});
            })

            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {"courses": selected_courses, "post_id": post_id, action: "update_product_courses"},
                success: function (data) {
                    console.log("Success : ", data)
                    // $(row).find('.spinner').removeClass('is-active')
                },
                failure: function () {
                    console.log("Failure")
                    // $(row).find('.spinner').removeClass('is-active')
                }
            })
        }

        function deletePostData(post_id, data) {
            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {"post_id": post_id, action: "delete_product_courses"},
                success: function (data) {
                    console.log("Success : ", data)
                    // $(row).find('.spinner').removeClass('is-active')
                },
                failure: function () {
                    console.log("Failure")
                    // $(row).find('.spinner').removeClass('is-active')
                }
            })
        }

        $('.delete-row').on('click', function(e) {
            var data = $(e.target).parent().siblings().find('.product').select2('data');
            let courses = $(e.target).parent().siblings().find('.courses').select2('data');
            if (data.length && courses.length) {
                deletePostData(data[0].id)
            }
            $(e.target).parent().parent().remove()
        });

        $('.add').on('click', function() {
            var html = $(`
            			<div class="flex">
				<div class="select_box">
					<p><strong>When user purchase this product</strong></p>
                    <select class="product" style="width:100%"> </select>
				</div>

				<div class="select_box">
					<p><strong>These courses will be assigned to user</strong></p>
                    <select class="courses" multiple="multiple" style="width:100%"> </select>
				</div>

                <div class="delete_icon">
                    <a href="#" class="delete-row">
                        <svg style="height: 24px; width: 24px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
			</div>
            `)
            $('.content .new_items').append(html)
            initializeSelect2(html)
        })
    })
</script>