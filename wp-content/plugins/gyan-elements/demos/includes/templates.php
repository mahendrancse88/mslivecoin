<?php
// TMPL - Single Demo Preview, No more demos, Filters, List
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<script type="text/template" id="tmpl-gyn-template-base-skeleton">
	<div class="dialog-widget dialog-lightbox-widget dialog-type-buttons dialog-type-lightbox" id="gyn-sites-modal">
		<div class="dialog-widget-content dialog-lightbox-widget-content">
			<div class="gyan-sites-content-wrap" data-page="1">
				<div class="gyn-template-library-toolbar">
					<div class="elementor-template-library-filter-toolbar">

						<div class="gyan-blocks-category-inner-wrap">
							<select id="elementor-template-library-filter" class="gyan-blocks-category elementor-template-library-filter-select elementor-select2">
								<option value=""><?php esc_html_e( 'All', 'gyan-elements' ); ?></option>
								<# for ( key in gyanElementorSites.gyan_block_categories ) { #>
								<option value="{{gyanElementorSites.gyan_block_categories[key].id}}">{{gyanElementorSites.gyan_block_categories[key].name}}</option>
								<# } #>
							</select>
						</div>
						<div class="gyan-blocks-filter-inner-wrap">
							<select id="elementor-template-library-filter" class="gyan-blocks-filter elementor-template-library-filter-select elementor-select2">
								<option value=""><?php esc_html_e( 'Filter by Color', 'gyan-elements' ); ?></option>
								<option value="light"><?php esc_html_e( 'Light', 'gyan-elements' ); ?></option>
								<option value="dark"><?php esc_html_e( 'Dark', 'gyan-elements' ); ?></option>
							</select>
						</div>
					</div>
					<div class="gyn-sites-template-library-filter-text-wrapper">
						<label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php esc_html_e( 'Search...', 'gyan-elements' ); ?></label>
						<input id="wp-filter-search-input" placeholder="<?php esc_html_e( 'SEARCH', 'gyan-elements' ); ?>" class="">
						<i class="eicon-search"></i>
					</div>
				</div>
				<div id="gyn-sites-floating-notice-wrap-id" class="gyn-sites-floating-notice-wrap"><div class="gyn-sites-floating-notice"></div></div>
				<?php
				$manual_sync = get_site_option( 'gyan-sites-manual-sync-complete', 'no' );
				if ( 'yes' === $manual_sync ) {
					$batch_status = get_site_option( 'gyan-sites-batch-is-complete', 'no' );
					if ( 'yes' === $batch_status ) {
						?>
						<div class="gyn-sites-floating-notice-wrap refreshed-notice slide-in">
							<div class="gyn-sites-floating-notice">
								<div class="gyan-sites-sync-library-message success gyan-sites-notice notice notice-success is-dismissible">
									<?php Gyan_Sites::get_instance()->get_sync_complete_message( true ); ?> <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss', 'gyan-elements' ); ?></span></button>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>
				<div class="dialog-message dialog-lightbox-message" data-type="pages">
					<div class="dialog-content dialog-lightbox-content theme-browser"></div>
					<div class="theme-preview"></div>
				</div>
				<div class="dialog-message dialog-lightbox-message-block" data-type="blocks">
					<div class="dialog-content dialog-lightbox-content-block theme-browser" data-block-page="1"></div>
					<div class="theme-preview-block"></div>
				</div>
				<div class="gyan-loading-wrap"><div class="gyan-loading-icon"></div></div>
			</div>
			<div class="dialog-buttons-wrapper dialog-lightbox-buttons-wrapper"></div>
		</div>
		<div class="dialog-background-lightbox"></div>
	</div>
</script>

<script type="text/template" id="tmpl-gyn-template-modal__header">
	<div class="dialog-header dialog-lightbox-header">
		<div class="gyn-sites-modal__header">
			<div class="gyn-sites-modal__header__logo-area">
				<div class="gyn-sites-modal__header__logo">
					<span class="gyn-sites-modal__header__logo__icon-wrapper"></span>
				</div>
				<div class="back-to-layout" title="<?php esc_html_e( 'Back to Layout', 'gyan-elements' ); ?>" data-step="1"><i class="eicon-chevron-left"></i></div>
			</div>
			<div class="elementor-templates-modal__header__menu-area gyan-sites-step-1-wrap gyn-sites-modal__options">
				<div class="elementor-template-library-header-menu">
					<div class="elementor-template-library-menu-item elementor-active" data-template-source="remote" data-template-type="pages"><span class="gyn-icon-file"></span><?php esc_html_e( 'Pages', 'gyan-elements' ); ?></div>
					<div class="elementor-template-library-menu-item" data-template-source="remote" data-template-type="blocks"><span class="gyn-icon-layers"></span><?php esc_html_e( 'Blocks', 'gyan-elements' ); ?></div>
				</div>
			</div>
			<div class="elementor-templates-modal__header__items-area">
				<div class="gyn-sites-modal__header__close gyn-sites-modal__header__close--normal gyn-sites-modal__header__item">
					<i class="eicon-close" aria-hidden="true" title="<?php esc_html_e( 'Close', 'gyan-elements' ); ?>"></i>
					<span class="elementor-screen-only"><?php esc_html_e( 'Close', 'gyan-elements' ); ?></span>
				</div>
				<div class="gyan-sites__sync-wrap">
					<div class="gyan-sites-sync-library-button">
						<span class="eicon-sync" aria-hidden="true" title="<?php esc_html_e( 'Refresh Demos', 'gyan-elements' ); ?>"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-gyan-sites-list">

	<#
		var count = 0;
		for ( key in data ) {
			var page_data = data[ key ][ 'pages' ];
			var site_type = data[ key ][ 'gyan-sites-type' ] || '';
			if ( 0 == Object.keys( page_data ).length ) {
				continue;
			}
			if ( undefined == site_type ) {
				continue;
			}

			var type_class = ' site-type-' + data[ key ]['gyan-sites-type'];
			var site_title = data[ key ]['title'].slice( 0, 25 );
			if ( data[ key ]['title'].length > 25 ) {
				site_title += '...';
			}
			count++;
	#>
			<div class="theme gyan-theme site-single publish page-builder-elementor {{type_class}}" data-site-id={{key}} data-template-id="">
				<div class="inner">
					<span class="site-preview" data-href="" data-title={{site_title}}>
						<div class="theme-screenshot one loading" data-step="1" data-src={{data[ key ]['thumbnail-image-url']}} data-featured-src={{data[ key ]['featured-image-url']}}>
							<div class="elementor-template-library-template-preview">
								<i class="eicon-zoom-in" aria-hidden="true"></i>
							</div>
						</div>
					</span>
					<div class="theme-id-container">
						<h3 class="theme-name">{{{site_title}}}</h3>
					</div>
				</div>
			</div>
	<#
		}
	#>
</script>

<script type="text/template" id="tmpl-gyan-blocks-list">

	<#
		var count = 0;
		let upper_window = ( GyanElementorSitesAdmin.per_page * ( GyanElementorSitesAdmin.page - 1 ) );
		let lower_window = ( upper_window + GyanElementorSitesAdmin.per_page );

		for ( key in data ) {

			var site_title = ( undefined == data[ key ]['category'] || 0 == data[ key ]['category'].length ) ? data[ key ]['title'] : gyanElementorSites.gyan_block_categories[data[ key ]['category']].name;

			if ( '' !== GyanElementorSitesAdmin.blockCategory ) {
				if ( GyanElementorSitesAdmin.blockCategory != data[ key ]['category'] ) {
					continue;
				}
			}

			if ( '' !== GyanElementorSitesAdmin.blockColor ) {
				if ( undefined !== data[ key ]['filter'] && GyanElementorSitesAdmin.blockColor != data[ key ]['filter'] ) {
					continue;
				}
			}
			count++;
	#>
		<div class="gyan-sites-library-template gyan-theme" data-block-id={{key}}>
			<div class="gyan-sites-library-template-inner" >
				<div class="elementor-template-library-template-body theme-screenshot" data-step="1">
					<img src="{{data[ key ]['thumbnail-image-url']}}">
					<div class="elementor-template-library-template-preview">
						<i class="eicon-zoom-in" aria-hidden="true"></i>
					</div>
				</div>
				<div class="elementor-template-library-template-footer">
					<div class="elementor-template-library-template-name theme-id-container">{{{site_title}}}</div>
					<a class="elementor-template-library-template-action elementor-template-library-template-insert gyn-block-insert">
						<i class="eicon-file-download" aria-hidden="true"></i>
						<span class="elementor-button-title"><?php esc_html_e( 'INSERT', 'gyan-elements' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	<#
		}
		if ( count == 0 ) {
	#>
		<div class="gyan-sites-no-sites">
			<div class="inner">
				<h3><?php esc_html_e( 'Sorry No Results Found.', 'gyan-elements' ); ?></h3>
				<div class="content">
					<div class="description">
						<div class="back-to-layout-button"><span class="button gyan-sites-back"><?php esc_html_e( 'Back to Templates', 'gyan-elements' ); ?></span></div>
					</div>
				</div>
			</div>
		</div>
	<#
		}
	#>
</script>

<script type="text/template" id="tmpl-gyan-sites-list-search">

	<#
		var count = 0;

		for ( ind in data ) {
			var site_type = data[ ind ]['site-pages-type'];
			var type_class = ' site-type-' + site_type;
			var site_id = ( undefined == data.site_id ) ? data[ind].site_id : data.site_id;
			if ( undefined == site_type ) {
				continue;
			}
			if ( 'gutenberg' == data[ind]['site-pages-page-builder'] ) {
				continue;
			}
			var site_title = data[ ind ]['title'].slice( 0, 25 );
			if ( data[ ind ]['title'].length > 25 ) {
				site_title += '...';
			}
			count++;
	#>
		<div class="theme gyan-theme site-single publish page-builder-elementor {{type_class}}" data-template-id={{ind}} data-site-id={{site_id}}>
			<div class="inner">
				<span class="site-preview" data-href="" data-title={{site_title}}>
					<div class="theme-screenshot one loading" data-step="2" data-src={{data[ ind ]['thumbnail-image-url']}} data-featured-src={{data[ ind ]['featured-image-url']}}>
						<div class="elementor-template-library-template-preview">
							<i class="eicon-zoom-in" aria-hidden="true"></i>
						</div>
					</div>
				</span>
				<div class="theme-id-container">
					<h3 class="theme-name">{{{site_title}}}</h3>
				</div>
			</div>
		</div>
	<#
		}

		if ( count == 0 ) {
	#>
		<div class="gyan-sites-no-sites">
			<div class="inner">
				<h3><?php esc_html_e( 'Sorry No Results Found.', 'gyan-elements' ); ?></h3>
				<div class="content">
					<div class="description">
						<div class="back-to-layout-button"><span class="button gyan-sites-back"><?php esc_html_e( 'Back to Templates', 'gyan-elements' ); ?></span></div>
					</div>
				</div>
			</div>
		</div>
	<#
		}
	#>
</script>

<script type="text/template" id="tmpl-gyan-sites-search">

	<#
		var count = 0;

		for ( ind in data ) {
			if ( 'gutenberg' == data[ind]['site-pages-page-builder'] ) {
				continue;
			}

			var site_id = ( undefined == data.site_id ) ? data[ind].site_id : data.site_id;
			var site_type = data[ ind ]['site-pages-type'];

			if ( 'site' == data[ind]['type'] ) {
				site_type = data[ ind ]['gyan-sites-type'];
			}

			if ( undefined == site_type ) {
				continue;
			}

			var parent_name = '';
			if ( undefined != data[ind]['parent-site-name'] ) {
				var parent_name = jQuery( "<textarea/>") .html( data[ind]['parent-site-name'] ).text();
			}

			var complete_title = parent_name + ' - ' + data[ ind ]['title'];
			var site_title = complete_title.slice( 0, 25 );
			if ( complete_title.length > 25 ) {
				site_title += '...';
			}

			var tmp = site_title.split(' - ');
			var title1 = site_title;
			var title2 = '';
			if ( undefined !== tmp && undefined !== tmp[1] ) {
				title1 = tmp[0];
				title2 = ' - ' + tmp[1];
			} else {
				title1 = tmp[0];
				title2 = '';
			}

			var type_class = ' site-type-' + site_type;
			count++;
	#>
		<div class="theme gyan-theme site-single publish page-builder-elementor {{type_class}}" data-template-id={{ind}} data-site-id={{site_id}}>
			<div class="inner">
				<span class="site-preview" data-href="" data-title={{title2}}>
					<div class="theme-screenshot one loading" data-type={{data[ind]['type']}} data-step={{data[ind]['step']}} data-show="search" data-src={{data[ ind ]['thumbnail-image-url']}} data-featured-src={{data[ ind ]['featured-image-url']}}></div>
				</span>
				<div class="theme-id-container">
					<h3 class="theme-name"><strong>{{title1}}</strong>{{title2}}</h3>
				</div>
			</div>
		</div>
	<#
		}

		if ( count == 0 ) {
	#>
		<div class="gyan-sites-no-sites">
			<div class="inner">
				<h3><?php esc_html_e( 'Sorry No Results Found.', 'gyan-elements' ); ?></h3>
				<div class="content">
					<div class="description">
						<div class="back-to-layout-button"><span class="button gyan-sites-back"><?php esc_html_e( 'Back to Templates', 'gyan-elements' ); ?></span></div>
					</div>
				</div>
			</div>
		</div>
	<#
		}
	#>
</script>

<script type="text/template" id="tmpl-gyan-sites-insert-button">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item" data-template-id={{data.template_id}} data-site-id={{data.site_id}}>
		<a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button">
			<i class="eicon-file-download" aria-hidden="true"></i>
			<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'gyan-elements' ); ?></span>
		</a>

	</div>
</script>

<?php
// TMPL - Third Party Required Plugins
?>
<script type="text/template" id="tmpl-gyan-sites-third-party-required-plugins">
	<div class="skip-and-import">
		<div class="heading">
			<h3><?php esc_html_e( 'Required Plugins Missing', 'gyan-elements' ); ?></h3>
			<span class="dashicons close dashicons-no-alt"></span>
		</div>
		<div class="gyan-sites-import-content">
			<p><?php esc_html_e( 'This demo site requires premium plugins. As these are third party premium plugins, you\'ll need to install and activate them first.', 'gyan-elements' ); ?></p>
			<ul class="gyan-sites-third-party-required-plugins">
				<# for ( key in data ) { #>
					<li class="plugin-card plugin-card-{{data[ key ].slug}}'" data-slug="{{data[ key ].slug }}" data-init="{{data[ key ].init}}" data-name="{{data[ key ].name}}"><a href="{{data[ key ].link}}" target="_blank">{{data[ key ].name}}</a></li>
				<# } #>
			</ul>
		</div>
		<div class="gyn-btn-actions-wrap">
			<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import-step"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
			<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-gyan-sites-no-sites">
	<div class="gyan-sites-no-sites">
		<div class="inner">
			<h3><?php esc_html_e( 'Sorry No Results Found.', 'gyan-elements' ); ?></h3>
			<div class="content">
				<div class="description">
					<div class="back-to-layout-button"><span class="button gyan-sites-back"><?php esc_html_e( 'Back to Templates', 'gyan-elements' ); ?></span></div>
				</div>
			</div>
		</div>
	</div>
	<#
</script>

<script type="text/template" id="tmpl-gyan-sites-elementor-preview">
	<#
	let wrap_height = $elscope.find( '.gyan-sites-content-wrap' ).height();
	wrap_height = ( wrap_height - 55 );
	wrap_height = wrap_height + 'px';
	#>
	<div id="gyan-blocks" class="themes wp-clearfix" data-site-id="{{data.id}}" style="display: block;">
		<div class="single-site-wrap">
			<div class="single-site">
				<div class="single-site-preview-wrap">
					<div class="single-site-preview" style="max-height: {{wrap_height}};">
						<img class="theme-screenshot" data-src="" src="{{data['featured-image-url']}}">
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-gyan-sites-elementor-preview-actions">
	<#
	var demo_link = '';
	var action_str = '';
	if ( 'blocks' == GyanElementorSitesAdmin.type ) {
		demo_link = gyanElementorSites.gyan_blocks[GyanElementorSitesAdmin.block_id]['url'];
		action_str = 'Block';
	} else {
		demo_link = data['gyan-page-url'];
		action_str = 'Template';
	}
	#>
	<div class="gyan-preview-actions-wrap">
		<div class="gyan-preview-actions-inner-wrap">
			<div class="gyan-preview-actions">
				<div class="site-action-buttons-wrap">
					<div class="gyan-sites-import-template-action site-action-buttons-right">
						<div class="gyan-sites-tooltip"><span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-tooltip-plugins-settings"><span class="dashicons dashicons-editor-help"></span></span></div>
						<div type="button" class="button button-hero button-primary gyn-library-template-insert disabled"><?php esc_html_e( 'Import ', 'gyan-elements' ); ?>{{action_str}}</div>
					</div>
				</div>
			</div>
			<div class="gyn-tooltip-wrap">
				<div>
					<div class="gyn-tooltip-inner-wrap" id="gyan-sites-tooltip-plugins-settings">
						<ul class="required-plugins-list"><span class="spinner is-active"></span></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<?php
