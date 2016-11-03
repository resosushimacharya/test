function init_slick_slider() {
    jQuery(".cat_slider").length && jQuery(".cat_slider").slick({
        dots: !0,
        infinite: !1,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: !1
    })
}
$ = jQuery.noConflict(), $(function() {
    $('[data-toggle="tooltip"]').length && $('[data-toggle="tooltip"]').tooltip({
        html: !0
    }), init_slick_slider()
}), jQuery(document).ready(function(a) {
    function e(a) {
        var b = jQuery(a).find(".images").html(),
            c = jQuery(a).find(".summary.entry-summary").html(),
            d = jQuery(a).find("#tab-accesories_tab").html(),
            e = jQuery(a).find("#tab-additional_information").html(),
            f = jQuery(a).find("#tab-specifications_tab").html(),
            g = jQuery(a).find("#tab-guides_tab").html(),
            h = jQuery(a).find("#tab-faq_tab").html(),
            i = jQuery(a).find("#tab-ret_tab").html(),
            j = jQuery(a).find("#you_may_like-content").html();
        jQuery(document).find(".images").html(b), jQuery(document).find(".summary.entry-summary").html(c), jQuery(document).find("#tab-accesories_tab").html(d), jQuery(document).find("#tab-additional_information").html(e), jQuery(document).find("#tab-specifications_tab").html(f), jQuery(document).find("#tab-guides_tab").html(g), jQuery(document).find("#tab-faq_tab").html(h), jQuery(document).find("#tab-ret_tab").html(i), jQuery(document).find("#you_may_like-content").html(j), jQuery(document).find(".main-image-wrapper a.zoom").removeAttr("data-rel").prettyPhoto({
            hook: "data-rel",
            social_tools: !1,
            theme: "pp_woocommerce",
            horizontal_padding: 20,
            opacity: .8,
            deeplinking: !1
        })
    }

    function f(b) {
        a("body, .banner ").addClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").show();
        var c = jQuery("#perpage_var").val(),
            d = a("#ajax_cat_id").val(),
            e = a("#ajax_offset").val(),
            f = a("#ajax_sort_by").val(),
            g = a("#ajax_sort_order").val(),
            h = a("#cat_depth").val(),
            i = a("#selected_colors").val(),
            j = a("#selected_sizes").val(),
            k = jQuery("#selected_shop_range").val(),
            l = a("#price_range_filter").val(),
            m = {
                action: jQuery("#cc_load_more").attr("callto"),
                perpage: c,
                cat_id: d,
                offset: e,
                sort_by: f,
                sort_order: g,
                depth: h,
                color: i,
                size: j,
                price: l,
                s: jQuery("#search_query").val(),
                shop_range: k
            };
        jQuery.post(woo_load_autocomplete.ajax_url, m, function(a) {
            output = jQuery.parseJSON(a), "" == output.html || 0 == output.found_prod ? (output.html = '<span class="no_product"> No Products Found </span>', jQuery("#cc_load_more").attr("disabled", "disabled").val("No More Products")) : jQuery("#cc_load_more").removeAttr("disabled").val("Load More"), a = JSON.stringify(output), b(a)
        }).done(function() {
            a("body, .banner ").removeClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").hide(), output.found_prod < c ? jQuery("#cc_load_more").hide() : "yes" == jQuery("#hide_loadmore").val() ? jQuery("#cc_load_more").hide() : jQuery("#cc_load_more").show()
        })
    }
    var b = 802,
        c = {
            lazyLoad: "ondemand",
            dots: !0,
            infinite: !0,
            slidesToShow: 1,
            slidesToScroll: 1,
            mobileFirst: !0,
            responsive: [{
                breakpoint: b,
                settings: "unslick"
            }]
        },
        d = function() {
            0 == a(".product_single_thumb_slider .single-thumb-img").length ? a(".main-image-wrapper").show().addClass("no_slider") : a(".product_single_thumb_slider").slick(c)

        };
    d(), a(window).on("resize", function() {
        var c = a(window).width();
        c < b && d()
    }), jQuery(document).find(".cc_search_button").each(function(a, b) {
        jQuery(this).attr("disabled", "disabled")
    }), jQuery(document).on("keyup", "input[name=s]", function() {
        var a = jQuery(this).val();
        ("" == a || a.length < 3) ? jQuery(this).next(".input-group-btn").find(".cc_search_button").attr("disabled", "disabled") : jQuery(this).next(".input-group-btn").find(".cc_search_button").removeAttr("disabled")
    }), a("#pickup_location_form").on("keyup keypress", function(a) {
        var b = a.keyCode || a.which;
        13 === b && a.preventDefault()
    }), jQuery(document).on("focusout", "#billing_postcode, #shipping_postcode", function() {
        var a = jQuery(this).val();
        return a.match() ? (jQuery(this).parent(".validate-postcode").removeClass("woocommerce-invalid"), jQuery(this).parent(".validate-postcode").addClass("woocommerce-validated"), jQuery(this).parent().find("label#" + jQuery(this).attr("id") + "-error").remove(), void 0) : (jQuery(this).parent(".validate-postcode").addClass("woocommerce-invalid"), jQuery("label#" + jQuery(this).attr("id") + "-error").remove(), jQuery(this).parent().append('<label id="' + jQuery(this).attr("id") + '-error" class="error" for="' + jQuery(this).attr("id") + '">Please enter a valid Postcode.</label>').show(), jQuery(this).parent(".validate-postcode").removeClass("woocommerce-validated"), !1)
    }), jQuery(document).on("focusout", "#billing_postcode, #shipping_postcode", function() {
        var a = jQuery(this).val();
        if ("" == a) return jQuery(this).parent(".validate-postcode").addClass("woocommerce-invalid"), !1;
        var b = /^\d{4}$/;
        return a.match(b) ? (jQuery(this).parent(".validate-postcode").removeClass("woocommerce-invalid"), jQuery(this).parent(".validate-postcode").addClass("woocommerce-validated"), jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").hide(), void 0) : (jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").length ? jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").show() : jQuery(this).parent().append('<label id="' + jQuery(this).attr("id") + '-errormessage" class="cc_error" for="' + jQuery(this).attr("id") + '">Please enter a valid Post Code.</label>').show(), jQuery(this).parent(".validate-postcode").addClass("woocommerce-invalid"), !1)
    }), jQuery(document).on("focusout", "#billing_phone:visible, #shipping_phone:visible", function() {
        var a = jQuery(this).val();
        if ("" != a) {
            var b = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;
            if (!a.match(b)) return jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").length ? jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").show() : jQuery(this).parent().append('<label id="' + jQuery(this).attr("id") + '-errormessage" class="cc_error" for="' + jQuery(this).attr("id") + '">Please enter a valid phone number.</label>').show(), jQuery(this).parent(".validate-phone").addClass("woocommerce-invalid"), !1;
            jQuery(this).parent(".validate-phone").removeClass("woocommerce-invalid"), jQuery(this).parent(".validate-phone").addClass("woocommerce-validated"), jQuery(document).find("label#" + jQuery(this).attr("id") + "-errormessage").hide()
        }
    }), jQuery(document).on("focusout", "#billing_state, #shipping_state", function() {
        var a = jQuery(this).val();
        return "" == a ? (jQuery(this).addClass("cc_error_checkout"), !1) : void jQuery(this).removeClass("cc_error_checkout")
    }), jQuery(document).on("click", "#place_order", function(a) {
        a.preventDefault();
        var b = jQuery('input[name="payment_method"]:checked').val();
        if ("securepay" == b) {
            var c = !1,
                d = "";
            jQuery(".payment_box.payment_method_securepay").find("input, select").each(function(a, b) {
                "" == jQuery(b).val() ? (c = !0, jQuery(b).addClass("cc_error_checkout"), d = b) : jQuery(b).removeClass("cc_error_checkout")
            });
            var e = new Date(jQuery("#expyear").val(), parseInt(jQuery("#expmonth").val()) - 1);
            if (e < new Date ? (c = !0, jQuery("#expyear, #expmonth").addClass("cc_error_checkout"), jQuery("#securepay_exp_date-errormessage").length > 0 ? jQuery("#securepay_exp_date-errormessage").show() : jQuery("#expyear").parent("td").append('<label id="securepay_exp_date-errormessage" class="cc_error" for="securepay_exp_date">Invalid expiry date!</label>')) : (jQuery("#securepay_exp_date-errormessage").hide(), jQuery("select#expmonth, select#expyear").removeClass("cc_error_checkout")), c) return !1;
            jQuery('form[name="checkout"]').submit()
        } else jQuery('form[name="checkout"]').submit()
    }), jQuery(document).on("change", "#expmonth, #expyear", function() {
        if ("" != jQuery("#expmonth").val() && "" != jQuery("#expyear").val()) {
            var a = !1,
                b = new Date(jQuery("#expyear").val(), parseInt(jQuery("#expmonth").val()) - 1);
            if (b < new Date ? (a = !0, jQuery("#expyear, #expmonth").addClass("cc_error_checkout"), jQuery("#securepay_exp_date-errormessage").length > 0 ? jQuery("#securepay_exp_date-errormessage").show() : jQuery("#expyear").parent("td").append('<label id="securepay_exp_date-errormessage" class="cc_error" for="securepay_exp_date">Invalid expiry date!</label>')) : (jQuery("select#expmonth, select#expyear").removeClass("cc_error_checkout"), jQuery("#securepay_exp_date-errormessage").hide()), a) return jQuery("#place_order").attr("disabled", "disabled"), !1;
            jQuery("#place_order").removeAttr("disabled")
        }
    }), jQuery(document).on("keyup, focusout", 'input[name="cardno"]', function() {
        var a = 16;
        return this.value = this.value.replace(/[^0-9\.]/g, ""), jQuery(this).val().length > a && jQuery(this).val(jQuery(this).val().substr(0, a)), jQuery(this).val().length != a ? (jQuery(this).addClass("cc_error_checkout"), jQuery("#place_order").attr("disabled", "disabled"), !1) : void jQuery("#place_order").removeAttr("disabled")
    }), jQuery(document).on("keyup, focusout", 'input[name="cardcvv"]', function() {
        var a = 3;
        return this.value = this.value.replace(/[^0-9\.]/g, ""), jQuery(this).val().length > a && jQuery(this).val(jQuery(this).val().substr(0, a)), jQuery(this).val().length != a ? (jQuery(this).addClass("cc_error_checkout"), jQuery("#place_order").attr("disabled", "disabled"), !1) : void jQuery("#place_order").removeAttr("disabled")
    }), jQuery(document).ajaxSuccess(function(a, b, c) {
        if (c.url.indexOf("checkout/?wc-ajax=checkout") >= 0) {
            jQuery(document).find(".cc_woocommerce-message").remove();
            var d = jQuery.parseJSON(b.responseText);
            "failure" == d.result && jQuery(".wc_payment_methods").prepend('<div class="cc_woocommerce-message">Please enter valid credit card details</div>')
        }
    }), jQuery(document).on("click", "#payment_method_securepay", function() {
        jQuery(".card_options").remove();
        var a = jQuery(".hidden_image_wrapper").html();
        jQuery(".payment_box.payment_method_securepay").prepend('<div class="card_options">' + a + "</div>")
    }), a('form[name="checkout"]').on("keyup keypress", function(a) {
        var b = a.keyCode || a.which;
        13 === b && a.preventDefault()
    }), jQuery(document).on("click", "#checkout_fetch_nearby_stores", function() {
        var a = jQuery("#edit_dialog_keyword").val().trim(),
			store_type = jQuery('#store_type').val();
            b = {
                action: "get_nearby_stores",
                address: a,
				store_type : store_type,
            };
        jQuery.post(woo_load_autocomplete.ajax_url, b, function(a) {
            a = jQuery.parseJSON(a), jQuery("#nearby_stores_main_wrapper").html(a), jQuery("#nearby_stores_main_wrapper").find(".input-radio").wrap('<label class="inner-radio-label"></label'), jQuery("#nearby_stores_main_wrapper").find(".input-radio").css("opacity", "0")
        })
    }), jQuery(document).on("click", "#checkout_fetch_nearby_stores_currentloc", function() {
        function a(a) {
            lat = a.coords.latitude, lon = a.coords.longitude;
			var store_type = jQuery('#store_type').val();
            var b = {
                action: "get_nearby_stores",
                latitude: lat,
                longitude: lon,
				store_type : store_type,
            };
            jQuery.post(woo_load_autocomplete.ajax_url, b, function(a) {
                a = jQuery.parseJSON(a), jQuery("#nearby_stores_main_wrapper").html(a), jQuery("#nearby_store_main_wrapper").find("input[type=radio]").each(function(a, b) {
                    jQuery(this).parent().hasClass("inner-radio-label") || (jQUery(this).wrap('<label class="inner-radio-label"></label>'), jQuery(b).parent("label")[b.checked ? "addClass" : "removeClass"](jQuery(b).is(":radio") ? "radio-check-label" : ""))
                })
            })
        }
        navigator.geolocation.getCurrentPosition(a)
    }), jQuery(document).on("change", ".delivery_option_both .pickup_location_list input[type=radio]", function(a) {
        jQuery(".delivery_option_both .pickup_location_list .inner-radio-label.radio-check-label").removeClass("radio-check-label"), jQuery(this).is(":checked") ? jQuery(this).parent("label").addClass("radio-check-label") : jQuery(this).parent("label").removeClass("radio-check-label")
    }), jQuery(document).on("change", ".delivery_option_hardflooring .pickup_location_list input[type=radio]", function(a) {
        jQuery(".delivery_option_hardflooring .pickup_location_list .inner-radio-label.radio-check-label").removeClass("radio-check-label"), jQuery(this).is(":checked") ? jQuery(this).parent("label").addClass("radio-check-label") : jQuery(this).parent("label").removeClass("radio-check-label")
    }), jQuery(document).on("change", ".delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list input[type=radio]", function(a) {
        jQuery(".delivery_option_rugs #nearby_stores_main_wrapper .pickup_location_list .inner-radio-label.radio-check-label").removeClass("radio-check-label"), jQuery(this).is(":checked") ? jQuery(this).parent("label").addClass("radio-check-label") : jQuery(this).parent("label").removeClass("radio-check-label")
    }), jQuery(".acc_list_item .acc_qnty .quantity select.qty").val(0).trigger("click"), jQuery("input#price_range_filter").length > 0 && jQuery("input#price_range_filter").slider().on("slideStop", function(a) {
        value = a.value, jQuery(".range_slider .price_from").text(value[0]), jQuery(".range_slider .price_to").text(value[1]), jQuery(".cc-count-clear").show(), jQuery("#ajax_offset").val(0), jQuery("#cc_load_more").attr("first", "yes"), jQuery("#price_range_filter").val(jQuery("#price_range_filter").attr("data-value")), f(function(a) {
            a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
        })
    }), a = jQuery.noConflict(), a(document).ready(function() {
        a("#store-count-quantity, .acc_add_to_cart").attr("href", "javascript:void(0)"), a("#store-count-quantity, .acc_add_to_cart").removeClass("add_to_cart_button"), a("#store-count-quantity, .acc_add_to_cart").removeClass("ajax_add_to_cart"), a(document).on("change", ".cc-quantiy-section #quantity-control", function() {
            $loadref = jQuery(".select-design-product-image.pro-active a.select_design").attr("href"), $stoq = a(".cc-quantiy-section  #quantity-control").val();
            var b = jQuery("#sizem2").val();
            if ("please select" != $stoq.toLowerCase()) {
                if (a("#store-count-quantity").attr("href", $loadref), a("#store-count-quantity").addClass("add_to_cart_button"), a("#store-count-quantity").addClass("ajax_add_to_cart"), a(".add_to_cart_button").attr("data-quantity", $stoq), a(".add_to_cart_button").data("quantity", $stoq), b) {
                    var c = $stoq * b;
                    jQuery(".total_coverage .coverage_value").text(c.toFixed(2)), jQuery(".acc_list_item.underlay .acc_rec_qty").each(function(a, b) {
                        if (jQuery(this).attr("tpm_ratio")) {
                            var d = Math.ceil(Number(c) / Number(jQuery(this).attr("tpm_ratio")));
							if(d > 100){
								jQuery(this).text(d), jQuery(this).parents(".acc_qnty").find("select.qty").val(100), jQuery(this).parents(".acc_qnty").find("select.qty").trigger("change").addClass('validation_dd_error');
								}else{
									jQuery(this).text(d), jQuery(this).parents(".acc_qnty").find("select.qty").val(d), jQuery(this).parents(".acc_qnty").find("select.qty").trigger("change").removeClass('validation_dd_error');
									}
                        }
                    })
                }
            } else a("#store-count-quantity").attr("href", "javascript:void(0)"), a("#store-count-quantity").removeClass("add_to_cart_button"), a("#store-count-quantity").removeClass("ajax_add_to_cart")
        }), a(document).on("change", ".acc_qnty .quantity select", function() {
            if ("please select" != jQuery(this).val().toLowerCase()) {
                var a = jQuery(this).parents(".acc_list_item").find("a.acc_add_to_cart");
                "0" == jQuery(this).val() ? (jQuery(this).addClass("cc_error"), jQuery(this).addClass("validation_dd_error"), jQuery(a).attr("data-quantity", 0), jQuery(a).removeClass("add_to_cart_button"), jQuery(a).removeClass("ajax_add_to_cart"), jQuery(a).attr("href", "javascript:void(0)")) : (jQuery(this).removeClass("cc_error"), jQuery(this).removeClass("validation_dd_error"), jQuery(a).attr("data-quantity", jQuery(this).val()), jQuery(a).addClass("add_to_cart_button"), jQuery(a).addClass("ajax_add_to_cart"), jQuery(a).attr("href", jQuery(a).attr("link")))
            }
        }), jQuery(document).on("click", ".acc_add_to_cart", function(a) {
            var b = jQuery(this).parents(".accessories_innner_wrap").find("#quantity-control");
            0 == jQuery(b).val() || "PLEASE SELECT" == jQuery(b).val() ? (jQuery(b).addClass("validation_dd_error"), a.preventDefault()) : jQuery(b).removeClass("validation_dd_error")
        })
    }), jQuery(document).on("mouseover", ".acc_list_item", function() {}), jQuery(document).find(".main-image-wrapper a.zoom").removeAttr("data-rel"), jQuery(document).on("click", ".select-design-product-image a.select_design", function(c) {
        c.preventDefault();
        var f = jQuery(this).attr("href"),
            g = jQuery(this).attr("title");
        window.history.pushState("object or string", "Title", f), a("body, .banner ").addClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").show(), jQuery.get(f, function(c) {
            if (e(c), jQuery("title").text(g + " - Carpet Call Australia"), a("body, .banner ").removeClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").hide(), jQuery("#store-count-quantity, .acc_add_to_cart").attr("href", "javascript:void(0)"), jQuery("#store-count-quantity, .acc_add_to_cart").removeClass("add_to_cart_button"), jQuery("#store-count-quantity, .acc_add_to_cart").removeClass("ajax_add_to_cart"), jQuery(".acc_qnty").find("select.qty").val(0), a(window).width() <= 800) {
                var f = a(".single-product-thumb-img");
                a(f).each(function() {
                    var b = a(this).attr("href");
                    a(this).find("img").attr("src", b)
                })
            }
            var h = jQuery(".pro-active"),
                i = jQuery(h).find(".selected-pro-name").text(),
                j = jQuery(h).find("img");
            j.clone().appendTo(".selected-product-img"), jQuery(".selected-product-name span").html(i);
            var k = a(window).width();
            k < b && d()
        })
    }), jQuery(document).on("click", "#store-count-quantity", function() {
        var a = jQuery(this).parents(".cc-quantiy-section").find("#quantity-control"),
            b = jQuery(a).val();
        return 0 == b || "" == b || "PLEASE SELECT" == b ? (jQuery(a).addClass("error").focus(), !1) : void jQuery(a).removeClass("error")
    }), jQuery(document).on("change", "select#cc-size", function(c) {
        var f = jQuery(this).val();
        window.history.pushState("object or string", "Title", f), a("body, .banner ").addClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").show(), jQuery.get(f, function(c) {
            if (e(c), a("body, .banner ").removeClass("ovelay_hidden_class"), jQuery("#loading_overlay_div").hide(), jQuery("#store-count-quantity").attr("href", "javascript:void(0)"), jQuery("#store-count-quantity").removeClass("add_to_cart_button"), jQuery("#store-count-quantity").removeClass("ajax_add_to_cart"), a(window).width() <= 800) {
                var f = a(".single-product-thumb-img");
                a(f).each(function() {
                    var b = a(this).attr("href");
                    a(this).find("img").attr("src", b)
                })
            }
            var g = jQuery(".pro-active"),
                h = jQuery(g).find(".selected-pro-name").text(),
                i = jQuery(g).find("img");
            i.clone().appendTo(".selected-product-img"), jQuery(".selected-product-name span").html(h);
            var j = a(window).width();
            j < b && d()
        })
    }), jQuery(document).on("click", ".single-product .images .thumbnails img", function(a) {
        a.preventDefault();
        var b = jQuery(this).parent("a").attr("href");
        jQuery(this).parents(".images").find(".main-image-wrapper .woocommerce-main-image img").attr("srcset", b).attr("src", b), jQuery(this).parents(".images").find(".main-image-wrapper a.woocommerce-main-image").attr("href", b)
    }), jQuery(document).on("click", ".cc-product-sort a", function() {
        jQuery("#ajax_offset").val(0)
    }), jQuery(document).on("click", ".cc-count-clear", function() {
        jQuery("input#price_range_filter").slider("refresh"), jQuery(".price_from").text(jQuery("input#price_range_filter").attr("data-slider-min")), jQuery(".price_to").text(jQuery("input#price_range_filter").attr("data-slider-max")), jQuery("a.clear_color_selection").hide(), jQuery("img.cc-tick-display").hide(), jQuery("#selected_colors").val(""), jQuery("#ajax_offset").val(0), jQuery("input.price_range").removeAttr("checked"), jQuery("#price_range_filter").val(""), jQuery("#selected_shop_range").val(""), jQuery("input.size_option").removeAttr("checked"), jQuery("input.shop_range").removeAttr("checked"), jQuery("#selected_sizes").val(""), jQuery(this).hide(), f(function(a) {
            a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
        }), jQuery("#ajax_offset").val(output.offset)
    }), jQuery(document).on("click", "a.clear_color_selection", function() {
        jQuery("img.cc-tick-display").hide(), jQuery(".swatch.select-color").removeClass("select-color"), jQuery("#selected_colors").val(""), jQuery("#ajax_offset").val(0), jQuery(this).hide(), f(function(a) {
            a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
        }), jQuery("#ajax_offset").val(output.offset)
    }), jQuery(document).on("click", ".cc-color-var-item a.swatch, .cc-shop-range-select .checkbox input[type=checkbox], .cc-size-var-sec .checkbox input[type=checkbox], .cc-product-sort a, .cc-price-var-items .checkbox input[type=checkbox]", function(a) {
        jQuery(".cc-count-clear").show(), jQuery("#ajax_offset").val(0), jQuery("#cc_load_more").attr("first", "yes");
        var b = a.target;
        if (jQuery(b).hasClass("swatch") || jQuery(b).parent().hasClass("swatch")) {
            jQuery(b).parent().hasClass("swatch") && (b = jQuery(b).parent()), jQuery("#selected_colors").val(""), jQuery(this).toggleClass("select-color"), jQuery(b).find("img.cc-tick-display").toggle();
            var c = "",
                d = "";
            jQuery(".cc-tick-display:visible").length > 0 ? jQuery(".clear_color_selection").show() : jQuery(".clear_color_selection").hide(), jQuery(".cc-tick-display:visible").each(function(a, b) {
                d = "" == c ? "" : ",", c += d + jQuery(b).parent().attr("id"), jQuery("#selected_colors").val(c)
            }), f(function(a) {
                a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
            })
        } else if (jQuery(b).hasClass("size_option")) {
            jQuery("#selected_sizes").val("");
            var e = "",
                d = "";
            jQuery(".size_option:checked").each(function(a, b) {
                d = "" == e ? "" : ",", e += d + jQuery(b).val(), jQuery("#selected_sizes").val(e)
            }), f(function(a) {
                a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
            })
        } else if (jQuery(b).hasClass("shop_range")) {
            jQuery("#selected_shop_range").val("");
            var g = "",
                d = "";
            jQuery(".shop_range:checked").each(function(a, b) {
                d = "" == g ? "" : ",", g += d + jQuery(b).val(), jQuery("#selected_shop_range").val(g)
            }), f(function(a) {
                a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
            })
        } else if (jQuery(b).parent().hasClass("sort_key")) {
            jQuery(".sort_key").removeClass("cc-count-active"), jQuery(b).parent("li").addClass("cc-count-active");
            var h = jQuery(this).attr("sort");
            jQuery("#ajax_sort_order").val("ASC"), "popular" == h ? (jQuery("#ajax_sort_by").val("popular"), jQuery("#ajax_sort_order").val("DESC")) : "price_low" == h ? jQuery("#ajax_sort_by").val("price") : "price_high" == h && (jQuery("#ajax_sort_by").val("price"), jQuery("#ajax_sort_order").val("DESC")), f(function(a) {
                a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").html(a.html), jQuery(".cc-cat-title-count .post_count").text(a.found_prod), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
            })
        }
    }), jQuery("#cc_load_more").click(function(a) {
        jQuery("#perpage_var").val();
        f(function(a) {
            a = jQuery.parseJSON(a), jQuery("#category_slider_block_wrapper").append(a.html);
            var b = parseInt(jQuery(".cc-cat-title-count .post_count").html()),
                c = parseInt(a.found_prod),
                d = b + c;
            jQuery(".cc-cat-title-count .post_count").html(d), jQuery("#cc_load_more").attr("first", "no"), jQuery("#ajax_offset").val(a.offset), jQuery(".cat_slider.slick-slider").slick("unslick"), init_slick_slider()
        })
    }), jQuery(document).on("click", ".select-dropdown-wrap", function() {
        jQuery(this).next(".cc-select-design-pro-all").toggleClass("show")
    })
});