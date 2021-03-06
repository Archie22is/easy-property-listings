<?php
/**
 * Welcome Page Class
 *
 * @package     EPL
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2014, Merv Barrett
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EPL_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.0
 */
class EPL_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'edit_published_posts';

	/**
	 * Get things started
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'epl_welcome' ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to Easy Property Listings', 'epl' ),
			__( 'Welcome to Easy Property Listings', 'epl' ),
			$this->minimum_capability,
			'epl-about',
			array( $this, 'about_screen' )
		);

		// Getting Started Page
		add_dashboard_page(
			__( 'Getting started with Easy Property Listings', 'epl' ),
			__( 'Getting started with Easy Property Listings', 'epl' ),
			$this->minimum_capability,
			'epl-getting-started',
			array( $this, 'getting_started_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'The people that build Easy Property Listings', 'epl' ),
			__( 'The people that build Easy Property Listings', 'epl' ),
			$this->minimum_capability,
			'epl-credits',
			array( $this, 'credits_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'epl-about' );
		remove_submenu_page( 'index.php', 'epl-getting-started' );
		remove_submenu_page( 'index.php', 'epl-credits' );

		// Badge for welcome page
		$badge_url = EPL_PLUGIN_URL . 'lib/assets/images/epl-wp-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.epl-badge {
			padding-top: 150px;
			height: 52px;
			width: 185px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.epl-about-wrap .epl-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.epl-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}
		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation tabs
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'epl-about';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'epl-about' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'epl-about' ), 'index.php' ) ) ); ?>">
				<?php _e( "What's New", 'epl' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'epl-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'epl-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'epl' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'epl-credits' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'epl-credits' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Credits', 'epl' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function about_screen() {
		list( $display_version ) = explode( '-', EPL_PROPERTY_VER );
		?>
		<div class="wrap about-wrap epl-about-wrap">
			<h1><?php printf( __( 'Welcome to Easy Property Listings %s', 'epl' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Easy Property Listings %s is ready to make your real estate website faster, safer and better!', 'epl' ), $display_version ); ?></div>
			<div class="epl-badge"><?php printf( __( 'Version %s', 'epl' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>
			
			<div class="changelog headline-feature">
			
				<h2><?php _e( 'Changes', 'epl' );?></h2>
			
				<div class="feature-section col two-col">
				
					<div>
						
						<h4><?php _e( 'Map Coordinates','epl' );?></h4>
						<p><?php _e( 'Map now uses coordinates and if they are not set, it will locate the listing and save the coordinates for faster display and map loading.', 'epl' );?></p>
						
						<h4><?php _e( 'Fancy Pagination','epl' );?></h4>
						<p><?php _e( 'You can now enable page numbers from settings for pagination which apply to templates and shortcodes.', 'epl' );?></p>
						
						<h4><?php _e( 'Meta Fields','epl' );?></h4>
						<ul>
							<li><?php _e( 'Rooms outputs in the feature list.', 'epl' );?></li>
							<li><?php _e( 'Date Listed saved for future enhancements.', 'epl' );?></li>
							<li><?php _e( 'Year Built will display in the feature list. ', 'epl' );?></li>
						</ul>
						
						<h4><?php _e( 'Bigger images in admin','epl' );?></h4>
						<p><?php _e( 'Select from 100 x 100 or 300 x 200 image size in admin.', 'epl' );?></p>
						
						<h4><?php _e( 'Shortcodes','epl' );?></h4>
						<p><?php _e( 'Use the <code>[listing_location]</code> shortcode to filter listings by location.', 'epl' );?></p>
						
						<h4><?php _e( 'Shortcode sorter','epl' );?></h4>
						<p><?php _e( 'Now you can add the sorter to your shortcodes with the <code>tools_top="on"</code> option.', 'epl' );?></p>
						
						<h4><?php _e( 'Shortcode filter by location','epl' );?></h4>
						<p><?php _e( 'Shortcodes now support filtering by location using <code>location="_location_slug"</code>', 'epl' );?></p>
						
					</div>
					
					<div class="last-feature">
						
						<h4><?php _e( 'Filtering by agent','epl' );?></h4>
						<p><?php _e( 'Search and sort listings by more values to keep better track of your listing stock.', 'epl' );?></p>
						
						<h4><?php _e( 'Table template','epl' );?></h4>
						<p><?php _e( 'Output a slim table list of listings by using <code>template="table"</code>', 'epl' );?></p>
						
						<h4><?php _e( 'Custom labels','epl' );?></h4>
						<p><?php _e( 'Need to change Under Offer or Leased? Customise the labels from the settings page.', 'epl' );?></p>
						
						<h4><?php _e( 'Commercial Lease Rate','epl' );?></h4>
						<p><?php _e( 'Decimal value and lease period for options like NNN, P.A., Full Service, Gross Lease Rates.', 'epl' );?></p>
						
						<h4><?php _e( 'Loading speed improvements','epl' );?></h4>
						<p><?php _e( 'Changes to only load scripts and CSS when they are needed. Many other optimisations to the code to reduce load times. Dashboard widget loads much faster.', 'epl' );?></p>
						
						<h4><?php _e( 'More listing types','epl' );?></h4>
						<p><?php _e( 'Need to have Boats, cars horse listings? We have made a number of changes to allow the addition of new listing types to be added. So you can have listings of anything.', 'epl' );?></p>
					</div>
					
				</div>

			</div>
			<hr>
			
			<div class="changelog headline-feature">
				<h2><?php _e( 'Extensions updated' , 'epl' );?></h2>
				
				<div class="feature-section">

					<p><?php _e( 'Each extension has been updated and tested with many new features added to each one. With your support we can offer even more tools to help you make better real estate websites. Our developer pack is better than ever, so be sure to browse the available add-ons in the store.', 'epl' );?> 
										
				</div>
			</div>
			<hr>

			<div class="changelog headline-feature">
			
			<h2 id="guide-changelog"><?php _e( 'Full Change Log','epl' );?></h2>
			
				<div class="feature-section">
				
					<h4><?php _e( 'Version 2.1.2', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Improved Responsive CSS for grid style.', 'epl' );?></li>
						<li><?php _e( 'Fix: Twenty Fifteen, Twenty Fourteen, Twenty Thirteen, Twenty Twelve CSS styles for better display.', 'epl' );?></li>
						<li><?php _e( 'New: Added CSS class theme name output to archive and single templates.', 'epl' );?></li>
					</ul>
				
					<h4><?php _e( 'Version 2.1.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Max price defaults set for graph calculations when upgrading from pre 2.0 version.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 2.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'New: Fancy pagination option which can be enabled in settings.', 'epl' );?></li>
						<li><?php _e( 'New: Coordinates now added to listing if not set prior.', 'epl' );?></li>
						<li><?php _e( 'New: Ability to select larger listing image sizes in admin.', 'epl' );?></li>
						<li><?php _e( 'New: Added date picker for available date on rental listing.', 'epl' );?></li>
						<li><?php _e( 'New: Added date picker for sold date.', 'epl' );?></li>
						<li><?php _e( 'New: New function that combines all meta box options into one global function for admin pages.', 'epl' );?></li>
						<li><?php _e( 'New: Display second agent name in admin listing lists.', 'epl' );?></li>
						<li><?php _e( 'New: Additional admin option to filter by agent/author. ', 'epl' );?></li>
						<li><?php _e( 'New: Shortcode [listing_location] to display listings by specific location.', 'epl' );?></li>
						<li><?php _e( 'New: The following shortcodes can now be filtered by location taxonomy: [listing location="perth"], [listing_open location="sydney"], [listing_category location="melbourne"], [listing_category location="brisbane"], [listing_feature feature="terrace" location="new-york"]', 'epl' );?></li>
						<li><?php _e( 'New: The following shortcodes can now be sorted by price, date and ordered by ASC and DESC [listing sortby="price" sort_order="ASC"].', 'epl' );?></li>
						<li><?php _e( 'New: Sorter added to shortcodes which can be enabled by adding tools_top="on" to your shortcode options.', 'epl' );?></li>
						<li><?php _e( 'New: Template added in table format for use in shortcodes template="table".', 'epl' );?></li>
						<li><?php _e( 'New: Function to get all active post types.', 'epl' );?></li>
						<li><?php _e( 'New: Ability to register additional custom post types.', 'epl' );?></li>
						<li><?php _e( 'New: Extensions now have additional help text ability.', 'epl' );?></li>
						<li><?php _e( 'New: All menus now use global function to render fields.', 'epl' );?></li>
						<li><?php _e( 'New: Improved template output and added additional CSS wrappers for some theme and HTML5 themes.', 'epl' );?></li>
						<li><?php _e( 'New: Commercial rental lease duration now selectable.', 'epl' );?></li>
						<li><?php _e( 'New: Rooms field added to set the number of rooms that the listing has.', 'epl' );?></li>
						<li><?php _e( 'New: Date listed field added to all listing types.', 'epl' );?></li>
						<li><?php _e( 'New: Year built field added to property, rental, rural listing types.', 'epl' );?></li>
						<li><?php _e( 'New: Media upload function for use in extensions.', 'epl' );?></li>
						<li><?php _e( 'New: Ability to customise Under Offer and Leased labels in settings.', 'epl' );?></li>
						<li><?php _e( 'New: Lease type label loaded from dropdown select. So you can have NNN, P.A., Full Service, Gross Lease Rates, on commercial listing types. Also has a filter to enable customisation of the options.', 'epl' );?></li>
						<li><?php _e( 'New: Disable links in the feature list.', 'epl' );?></li>
						<li><?php _e( 'Fix: Text domain fixes on template files.', 'epl' );?></li>
						<li><?php _e( 'Fix: Finnish translation file renamed.', 'epl' );?></li>
						<li><?php _e( 'Fix: FeedSync date processor strptime function corrected.', 'epl' );?></li>
						<li><?php _e( 'Fix: Bug in parking search field. Was only searching carports and not garages. Now searches both.', 'epl' );?></li>
						<li><?php _e( 'Fix: New label now appears on listings not just with an inspection time saved.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Optimised loading of admin scripts and styles to pages where required.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added version to CSS and JS so new versions are automatically used when plugin is updated.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Tidy up of admin CSS.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Video in author box now responsive.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Increased characters possible in address block fields from 40 to 80 characters and heading block to 200.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Coordinates now correctly being used to generate map.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Inspection times improved style in admin.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Commercial rental rate now accepts decimal numbers.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Improved google map output.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Improved default settings on upgrade, install and multisite.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Scripts improve site speed.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Dashboard widget improved query.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Front end CSS tweaks for better responsiveness.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 2.0.3', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Manually entered inspection capitalization fixed pM to PM.', 'epl' );?></li>
						<li><?php _e( 'New: French translation (Thanks to Thomas Grimaud)', 'epl' );?></li>
						<li><?php _e( 'New: Finnish translation (Thanks to Turo)', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 2.0.2', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Added fall-back diff() function which is not present in PHP 5.2 or earlier used with the New label.', 'epl' );?></li>
						<li><?php _e( 'Fix: Some Labels in settings were not saving correctly particularly the search widget labels.', 'epl' );?></li>
						<li><?php _e( 'Fix: Restored missing author profile contact form tab on author box.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added CSS version to admin CSS and front end CSS.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 2.0.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Attempted Twenty 15 CSS Fix but causes issues with other themes. Manual fix: Copy CSS from style-front.css to correct, margins and grid/sorter.', 'epl' );?></li>
						<li><?php _e( 'Fix: Restored Display of Inspection Label for properties with scheduled inspection times.', 'epl' );?></li>
						<li><?php _e( 'Fix: Search Widget security fix and performance improvements.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 2.0', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'New: Extension validator.', 'epl' );?></li>
						<li><?php _e( 'New: Depreciated listing-meta.php into compatibility folder.', 'epl' );?></li>
						<li><?php _e( 'New: Depreciated author-meta.php into compatibility folder.', 'epl' );?></li>
						<li><?php _e( 'New: Global variables: $property, $epl_author and $epl_settings.', 'epl' );?></li>
						<li><?php _e( 'New: Added filters for fields and groups in /lib/meta-boxes.php', 'epl' );?></li>
						<li><?php _e( 'New: Property custom meta re-written into class. This was the big change to 2.0 where we completely re-wrote the output of the meta values which are now accessible using global $property variable and easy template actions.', 'epl' );?></li>
						<li><?php _e( 'New: Property meta can now can be output using new actions for easy and quick custom template creation.', 'epl' );?></li>
						<li><?php _e( 'New: Reconstructed templates for single, archive & author pages', 'epl' );?></li>
						<li><?php _e( 'Tweak: Removed unused price script', 'epl' );?></li>
						<li><?php _e( 'Fix: Fixed warning related to static instance in strict standard modes', 'epl' );?></li>
						<li><?php _e( 'New: API for extensions now support WordPress editor with validation.', 'epl' );?></li>
						<li><?php _e( 'New: jQuery date time picker formatting added to improve support for auction and sold listing, support for 30+ languages support.', 'epl' );?></li>
						<li><?php _e( 'New: Inspection time auto-formats REAXML date eg [13-Dec-2014 11:00am to 11:45am] and will no longer show past inspection times.', 'epl' );?></li>
						<li><?php _e( 'New: Inspection time support multiple dates written one per line.', 'epl' );?></li>
						<li><?php _e( 'Tweak: CSS improved with better commenting and size reduction.', 'epl' );?></li>
						<li><?php _e( 'New: Dashboard widget now lists all listing status so at a glance you can see your property stock.', 'epl' );?></li>
						<li><?php _e( 'New: Display: To enable grid, list and sorter your custom archive-listing.php template requires the new action hook epl_template_before_property_loop before the WordPress loop.', 'epl' );?></li>
						<li><?php _e( 'New: Display: Utility hook action hook added epl_template_after_property_loop for future updates.', 'epl' );?></li>
						<li><?php _e( 'New: Display: List and grid view with optional masonry effect.', 'epl' );?></li>
						<li><?php _e( 'New: Display: Sorter added for price high/low and date newest/oldest.', 'epl' );?></li>
						<li><?php _e( 'New: Auction Date formats nicely. EG [Auction Saturday 28th December at 2:00pm].', 'epl' );?></li>
						<li><?php _e( 'New: Tabbed extensions page support in admin for advanced extensions like Listing Alerts.', 'epl' );?></li>
						<li><?php _e( 'New: Multiple author support in Author Box.', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Supports multiple listing types, hold Ctrl to enable tabbed front end display.', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Labels are configurable from the Display settings allowing you to set for example: Property to Buy and Rental to Rent and use a single widget to search multiple types.', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget and shortcode supports search by property ID, post Title, Land Area and Building Area.', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - removed extra fields from land, added labels for each property type to be shown as tab heading in search widget', 'epl' );?></li>
						<li><?php _e( 'Fix: Search Widget - Optimized total queries due to search widget from 1500 + to ~40', 'epl' );?></li>
						<li><?php _e( 'New: Author variables accessible using new CLASS.', 'epl' );?></li>
						<li><?php _e( 'New: Search short code supports array of property types.', 'epl' );?></li>
						<li><?php _e( 'New: REAXML date format function to format date correctly when using WP All Import Pro. Usage [epl_feedsync_format_date({./@modTime})].', 'epl' );?></li>
						<li><?php _e( 'New: REAXML Unit and lot formatting function for usage in the title when using WP All Import Pro. Usage [epl_feedsync_filter_sub_number({address[1]/subNumber[1]})].', 'epl' );?></li>
						<li><?php _e( 'New: Global $epl_settings settings variable adds new default values on plugin update.', 'epl' );?></li>
						<li><?php _e( 'New: Display: Added customisable label for rental Bond/Deposit.', 'epl' );?></li>
						<li><?php _e( 'New: Template functions completely re-written and can now be output using actions.', 'epl' );?></li>
						<li><?php _e( 'New: Added NEW sticker with customisable label and ability to set how long a listing displays the new label.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Compatibility fixes', 'epl' );?></li>
						<li><?php _e( 'New: Bar Graph API added.', 'epl' );?></li>
						<li><?php _e( 'New: Graph in admin allows you to set the max bar graph value. Default are (2,000,000 sale) and (2,000 rental).', 'epl' );?></li>
						<li><?php _e( 'New: Graph visually displays price and status.', 'epl' );?></li>
						<li><?php _e( 'New: Price graph now appears in admin pages quickly highlighting price and status visually.', 'epl' );?></li>
						<li><?php _e( 'New: Meta Fields: Support for unit number, lot number (land).', 'epl' );?></li>
						<li><?php _e( 'New: South African ZAR currency support.', 'epl' );?></li>
						<li><?php _e( 'Fix: Corrected Commercial Features ID Spelling', 'epl' );?></li>
						<li><?php _e( 'Tweak: YouTube video src to id function is replaced with better method which handles multiple YouTube video formats including shortened & embedded format', 'epl' );?></li>
						<li><?php _e( 'New: Adding Sold Date processing', 'epl' );?></li>
						<li><?php _e( 'Tweak: Updated shortcode templates', 'epl' );?></li>
						<li><?php _e( 'Tweak: Global $epl_author.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Fixed content/ into EPL_PATH_TEMPLATES_CONTENT', 'epl' );?></li>
						<li><?php _e( 'New: Support for older extensions added', 'epl' );?></li>
						<li><?php _e( 'New: Extension offers in menus general tab', 'epl' );?></li>
						<li><?php _e( 'Tweak: Renamed user profile options section to [Easy Property Listings: Author Box Profile].', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added better Bond/Deposit for rentals labels.', 'epl' );?></li>
						<li><?php _e( 'Fix: Deprecated author-meta.php in compatibility folder, class-author-meta.php has been created which will be used in place of author-meta.php & its variables in all author templates', 'epl' );?></li>
						<li><?php _e( 'New: Added template functions for author meta class, modified templates lib/templates/content/content-author-box-simple-card.php lib/templates/content/content-author-box-simple-grav.php lib/templates/content/content-author-box.php to use the template functions based on author meta class instead of variables from author-meta.php', 'epl' );?></li>
						<li><?php _e( 'New: author-meta.php depreciated and moved to compatibility directory. Variables globally available using $epl_author variable.', 'epl' );?></li>
						<li><?php _e( 'Tweak: listing-meta.php depreciated and moved to compatibility directory. Variables globally available with $property variable.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added Listing not Found to default templates when search performed with no results.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Improved Google maps address output for addresses containing # and /.', 'epl' );?></li>
						<li><?php _e( 'Fix: Listing Pages now have better responsive support for small screen devices like iPhone.', 'epl' );?></li>
						<li><?php _e( 'Fix: Default templates for Genesis and TwentyTwelve now show Listing Not Found when a search result returns empty.', 'epl' );?></li>
						<li><?php _e( 'Fix: Purged translations in epl.pot file.', 'epl' );?></li>
						<li><?php _e( 'Fix: Search Widget and short code drastically reduces database queries.', 'epl' );?></li>
						<li><?php _e( 'New: Templates are now able to be saved in active theme folder /easypropertylistings and edited. Plugin will use these first and fall back to plugin if not located in theme folder.', 'epl' );?></li>
						<li><?php _e( 'Fix: Extensions Notification and checker updated', 'epl' );?></li>
						<li><?php _e( 'New: updated author templates to use new author meta class', 'epl' );?></li>
						<li><?php _e( 'Fix: Added prefix to CSS tab-content class. Now epl-tab-content for compatibility.', 'epl' );?></li>
						<li><?php _e( 'New: Update user.php', 'epl' );?></li>
						<li><?php _e( 'Tweak: Improved internal documentation and updated screens.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Improved descriptions on author pages.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Better permalink flushing on activation, deactivation and install.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Extensive changes to admin descriptions and labels.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Optimising the php loading of files and scripts.', 'epl' );?></li>
						<li><?php _e( 'New: Define EPL_RUNNING added for extensions to check if plugin is active.', 'epl' );?></li>
						<li><?php _e( 'New: New options added to setting array when plugin is updated.', 'epl' );?></li>
						<li><?php _e( 'New: Old functions and files moved to plug-in /compatibility folder to ensure old code still works.', 'epl' );?></li>
						<li><?php _e( 'New: Meta Location Label.', 'epl' );?></li>
						<li><?php _e( 'New: Service banners on settings page.', 'epl' );?></li>
						<li><?php _e( 'New: Saving version number so when updating new settings are added.', 'epl' );?></li>
						<li><?php _e( 'New: iCal functionality for REAXML formatted inspection dates. Further improvements coming for manual date entry. ', 'epl' );?></li>
						<li><?php _e( 'New: Extensions options pages now with tabs for easier usage.', 'epl' );?></li>
						<li><?php _e( 'New: Added ID classes to admin pages and meta fields.', 'epl' );?></li>
						<li><?php _e( 'New: Filters to adjust land and building sizes from number to select fields.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Moved old extensions options page to compatibility folder so older extensions still work as expected.', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Added filter for land min & max fields in listing search widget', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Added filter for building min & max fields in listing search widget', 'epl' );?></li>
						<li><?php _e( 'Fix: For session start effecting certain themes', 'epl' );?></li>
						<li><?php _e( 'New: Land sizes now allow up to 5 decimal places', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Custom submit label', 'epl' );?></li>
						<li><?php _e( 'New: Search Widget - Can search by title in property ID / Address field', 'epl' );?></li>
						<li><?php _e( 'New: Added Russian Translation', 'epl' );?></li>
					</ul>
				
					<h4><?php _e( 'Version 1.2.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'Fix: Search Widget not working on page 2 of archive page in some instances', 'epl' );?></li>
						<li><?php _e( 'Fix: Property feature list Toilet and New Construction now display in list when ticked', 'epl' );?></li>
						<li><?php _e( 'Fix: EPL - Listing widget was not displaying featured listings', 'epl' );?></li>
						<li><?php _e( 'Fix: Allowed to filter by commercial_listing_type in [listing_category] shortcode', 'epl' );?></li>
						<li><?php _e( 'Fix: Updated templates to display Search Results when performing search', 'epl' );?></li>
						<li><?php _e( 'Fix: No longer show Bond when viewing rental list in admin', 'epl' );?></li>
						<li><?php _e( 'Fix: Open for inspection sticker now appears on rental properties', 'epl' );?></li>
						<li><?php _e( 'New: Added initial Dutch translation.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 1.2', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'New: Plug in Activation process flushes permalinks', 'epl' );?></li>
						<li><?php _e( 'New: Plug in deactivation flushes permalinks', 'epl' );?></li>
						<li><?php _e( 'New: Shortcode [listing_search]', 'epl' );?></li>
						<li><?php _e( 'New: Shortcode [listing_feature]', 'epl' );?></li>
						<li><?php _e( 'New: Shortcode [listing_open] replaces [home_open] shortcode. Retained [home_open] for backward compatibility, however adjust your site. ', 'epl' );?></li>
						<li><?php _e( 'New: Listing shortcodes allow for default template display if registered by adding template="slim" to the shortcode.', 'epl' );?></li>
						<li><?php _e( 'New: Translation support now correctly loads text domain epl', 'epl' );?></li>
						<li><?php _e( 'New: Added translation tags to all test elements for better translation support', 'epl' );?></li>
						<li><?php _e( 'New: Updated source epl.pot translation file for translations', 'epl' );?></li>
						<li><?php _e( 'New: Added very rough Italian translation', 'epl' );?></li>
						<li><?php _e( 'New: Wrapped Featured image in action to allow for easy removal and/or replacement', 'epl' );?></li>
						<li><?php _e( 'Fix: Undefined errors when debug is active', 'epl' );?></li>
						<li><?php _e( 'New: Added new CSS classes to widgets for consistent usage', 'epl' );?></li>
						<li><?php _e( 'Tweak: Admin CSS tweaks to define sections in admin', 'epl' );?></li>
						<li><?php _e( 'Fix: CSS for TwentyThirteen style CSS using .sidebar container', 'epl' );?></li>
						<li><?php _e( 'Fix: CSS for responsive shortcode', 'epl' );?></li>
						<li><?php _e( 'New: Added options to hide/ show various options to EPL - Listing widget: Property Headline, Excerpt, Suburb/Location Label, Street Address, Price, Read More Button', 'epl' );?></li>
						<li><?php _e( 'New: Added customisable "Read More" label to EPL - Listing widget', 'epl' );?></li>
						<li><?php _e( 'New: Added excerpt to EPL - Listing widget', 'epl' );?></li>
						<li><?php _e( 'New: Added options to remove search options from EPL - Listing Search widget', 'epl' );?></li>
						<li><?php _e( 'New: Added consistent CSS classes to shortcodes for responsive shortcode', 'epl' );?></li>
						<li><?php _e( 'New: Date processing function for use with WP All Import when importing REAXML files. Some imports set the current date instead of the date from the REAXML file. Usage in WP All Import Post Date is: [epl_feedsync_format_date({./@modTime})]', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added additional CSS classes to admin menu pages to extensions can be better distinguished when installed and activated', 'epl' );?></li>
						<li><?php _e( 'Fix: Registering custom template actions now works correctly', 'epl' );?></li>
						<li><?php _e( 'New: Added additional CSS classes to template files', 'epl' );?></li>
						<li><?php _e( 'Fix: Changed property not found wording when using search widget and listing not found. ', 'epl' );?></li>
						<li><?php _e( 'Tweak: Added defaults to widgets to prevent errors when debug is on', 'epl' );?></li>
						<li><?php _e( 'New: Added WordPress editor support in admin for use with extensions.', 'epl' );?></li>
						<li><?php _e( 'New: Added textarea support in admin for use with extensions.', 'epl' );?></li>
						<li><?php _e( 'New: Filters added for all select options on add listing pages which allows for full customisation through simple function', 'epl' );?></li>
						<li><?php _e( 'New: Added rent period, Day, Daily, Month, Monthly to rental listing types', 'epl' );?></li>
						<li><?php _e( 'New: Added property_office_id meta field', 'epl' );?></li>
						<li><?php _e( 'New: Added property_address_country meta field', 'epl' );?></li>
						<li><?php _e( 'Tweak: Allowed for decimal in bathrooms to allow for 1/2 baths eg 1.5', 'epl' );?></li>
						<li><?php _e( 'New: Added mini map to listing edit screen. Will display mini map in address block when pressing green coordinates button.', 'epl' );?></li>
						<li><?php _e( 'Fix: Updated admin columns for commercial_land listing type to match other listing type', 'epl' );?></li>
						<li><?php _e( 'Fix: Swapped bedrooms/bathroom label on hover', 'epl' );?></li>
						<li><?php _e( 'New: Added filter epl_listing_meta_boxes which allows additional meta boxes to be added through filter', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 1.1.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'New: Internationalisation support to enable customizing of post types: slug, archive, rewrite, labels, listing categories for meta_types.', 'epl' );?></li>
						<li><?php _e( 'New: Created filters for listing meta select fields: property_category, property_rural_category, property_commercial_category, property_land_category.', 'epl' );?></li>
						<li><?php _e( 'New: Created filters for each of the seven custom post types: labels, supports, slug, archive, rewrite, seven custom post types.', 'epl' );?></li>
						<li><?php _e( 'New: Shortcode [listing_category] This shortcode allows for you to output a list of listings by type and filter them by any available meta key and value.', 'epl' );?></li>
						<li><?php _e( 'Tweak: Updated search widget for filtered property_categories.', 'epl' );?></li>
						<li><?php _e( 'Fix: Listing categories were showing key, now showing value.', 'epl' );?></li>
						<li><?php _e( 'Fix: Settings were not showing up after saving, second refresh required setting variable to reload.', 'epl' );?></li>
					</ul>
					
					<h4><?php _e( 'Version 1.1', 'epl' );?></h4>
					<ul>
						<li><?php _e( 'First official release!', 'epl' );?></li>
					</ul>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'epl-general' ), 'admin.php' ) ) ); ?>"><?php _e( 'Go to Easy Property Listings Settings', 'epl' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Getting Started Screen
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function getting_started_screen() {
		list( $display_version ) = explode( '-', EPL_PROPERTY_VER );
		?>
		<div class="wrap about-wrap epl-about-wrap">
			<h1><?php printf( __( 'Welcome to Easy Property Listings %s', 'epl' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Easy Property Listings %s is ready to make your real estate website faster, safer and better!', 'epl' ), $display_version ); ?></div>
			<div class="epl-badge"><?php printf( __( 'Version %s', 'epl' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<div class="changelog headline-feature">
				<h2><?php _e( 'Real Estate Tools for WordPress', 'epl' );?></h2>
				
				<div class="featured-image">
					<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-welcome.png'; ?>" class="epl-welcome-featured-image"/>
				</div>
			</div>
			
			<div class="changelog headline-feature">
				<h2><?php _e( 'Quick Start Guide', 'epl' );?></h2>
				
				<h3 class="about-description" style="text-align: center;"><?php _e( 'Use the tips below to get started using Easy Property Listings. You will be up and running in no time!', 'epl' ); ?></h3>
				
				<div class="feature-section">
					<ul style="text-align: center;">
						<li><a href="#guide-configure"><?php _e( 'Activate the listing types you need & configure the plugin general settings', 'epl' ); ?></a></li>
						<li><a href="#guide-page"><?php _e( 'Create a blank page for each activated listing type', 'epl' ); ?></a></li>
						<li><a href="#guide-first-listing"><?php _e( 'Publish your first listing for testing your theme setup', 'epl' ); ?></a></li>
						
						<li><a href="#guide-theme"><?php _e( 'Setup your theme to work with the plugin', 'epl' ); ?></a></li>
						<li><a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'epl-about' ), 'index.php' ) ) ); ?>#guide-changelog"><?php _e( 'Full Change Log', 'epl' ); ?></a></li>
						<li><a href="#guide-help"><?php _e( 'Visit Support', 'epl' ); ?></a></li>
					</ul>
				</div>
			</div>
			<hr>
			
			<div class="changelog headline-feature">
			
				<h2 id="guide-configure"><?php _e( 'Activate the listing types you need', 'epl' );?></h2>
			
				<div class="feature-section">
				
					<div class="col">
					
						<p><?php _e( 'Visit the general settings page and enable the listing types you need. Once you have pressed save visit the Permalinks page to re-fresh your sites permalinks.', 'epl' );?></p>
						
						<p><?php _e( 'Instead of classifying everything as a property, Easy Property Listings allows you to separate the different listing types which is better for SEO and RSS feeds.', 'epl' );?></p>
						
						<p><strong><?php _e( 'Supported Listing Types', 'epl'); ?></strong></p>
						<ul>
							<li><?php _e( 'Property (Residential)', 'epl'); ?></li>
							<li><?php _e( 'Rental', 'epl'); ?></li>
							<li><?php _e( 'Land', 'epl'); ?></li>
							<li><?php _e( 'Rural', 'epl'); ?></li>
							<li><?php _e( 'Commercial', 'epl'); ?></li>
							<li><?php _e( 'Commercial Land', 'epl'); ?></li>
							<li><?php _e( 'Business', 'epl'); ?></li>
						</ul>
					</div>
					
					<div class="col">
						<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-general-settings.png'; ?>" class="epl-welcome-screenshots"/>
					</div>
				</div>
			</div>
			<hr>
			
			<div class="changelog headline-feature">
			
				<h2 id="guide-page"><?php _e( 'Create a blank page for each activated listing type', 'epl' );?></h2>
			
				<div class="feature-section">
					<div class="col">
						
						<p><?php _e( 'Doing this allows you to add "Property", "Land" and "Rental" pages to your WordPress menu. Add a new page for each listing type you activated.', 'epl' );?></p>
						
						<p><?php _e( 'For example, lets say you have activated: Property, Rental and Land. Create three pages, one called "Property", another "Land" and the third "Rental" these will be the custom post type slugs/permalinks eg: property, rental and land.', 'epl' );?></p>
						
						<p><?php _e( 'Publish a test "Property Listing" and visit your new property page and you will see the new property and others you have created.', 'epl' );?></p>
						
						<p><?php _e( 'Now you can rename them to whatever you like eg: "For Sale", "For Rent" etc, but leave the slug/permalink as it was,', 'epl' ); ?> <strong><?php _e( 'this is very important.', 'epl' );?></strong></p>
					
					</div>
					
					<div class="col">
						<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-default-pages.png'; ?>" class="epl-welcome-screenshots"/>
					</div>
				</div>
				
			</div>
			<hr>
			
			<div class="changelog headline-feature">
			
				<h2 id="guide-first-listing" class="epl-welcome-sub-heading"><?php _e( 'Publish Your First Listing', 'epl' );?></h2>
				
				<div class="featured-image">
					<?php echo wp_oembed_get('https://www.youtube.com/watch?v=h6B8LLecfbw', array('width'=>600)); ?>
				</div>
				<h3 class="epl-welcome-sub-heading"><?php _e( 'Title & Author', 'epl' );?></h3>
				
				<div class="feature-section">

					<div class="col">
					
						<h4><?php _e( 'Title', 'epl' );?></h4>
						<p><?php _e( 'Use the full listing address as the title.', 'epl' );?>
						
						<p><?php _e( 'When a property is being sold the "heading" is frequently changed and can cause permalink issues. Not to mention the search engine benefits.', 'epl' );?></p>
						
						<h4><?php _e( 'Author or Primary Real Estate Agent', 'epl' );?></h4>
						<p><?php _e( 'Select the author to show the name of the agent who has listed the property with their contact details. For best results each real estate agent should have their own WordPress user profile which allows for the output of their details on the listing and in widgets.', 'epl' );?></p>
						
					</div>
					
					<div class="col">
						<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-add-listing-title.png'; ?>" class="epl-welcome-screenshots"/>
					</div>
				</div>
				
				<h3 class="epl-welcome-sub-heading"><?php _e( 'Gallery and Featured Image', 'epl' );?></h3>
				<div class="feature-section">
						
					<div class="col">
						
						<h3><?php _e( 'Gallery', 'epl' );?></h3>
						<p><?php _e( 'Add a gallery of images to your listings with the WordPress Add Media button.' , 'epl' ); ?></p>
						
						<p><?php _e( 'You can automatically output a gallery from the Display options page.', 'epl' );?></p>
						
						<p><?php _e( 'If set to automatic, just upload your images to the listing and press x to close the media upload box once the images are attached to the listing. You can also easily adjust the number of gallery columns from the plugin Display options.', 'epl' );?></p>
						
						<h3><?php _e( 'Gallery Light Box', 'epl' );?></h3>
						<p><?php _e( 'Using a light box plug-in like Easy FancyBox, your automatic gallery images will use the light box effect.', 'epl' );?></p>

					</div>
					
					<div class="col">
						<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-add-listing-gallery.png'; ?>" class="epl-welcome-screenshots"/>
					</div>
					
				</div>
				
				
				<h3 style="font-size: 1.8em; text-align: center;"><?php _e( 'Listing Details', 'epl' );?></h3>
				
				<div class="feature-section">
					
					<div class="col">
						
						<h4><?php _e( 'Heading', 'epl' );?></h4>
						<p><?php _e( 'Enter the descriptive listing headline like "Great Property with Views".', 'epl' );?></p>
						
						<h4><?php _e( 'Second Listing Agent', 'epl' );?></h4>
						<p><?php _e( 'If the listing has two real estate agents marketing it, enter their WordPress user name here. The primary agent is the post Author.', 'epl' );?></p>
						
						<h4><?php _e( 'Inspection Times', 'epl' );?></h4>
						<p><?php _e( 'Now supports multiple inspection times, add one per line. Past inspection dates will not display when using the new format.', 'epl' );?></p> 
						
						<p><?php _e( 'The output is now wrapped in an iCal format so clicking on the date will open the users calendar.', 'epl' );?></p>
						
					</div>
					
					<div class="col">
						<img src="<?php echo EPL_PLUGIN_URL . 'lib/assets/images/screenshots/epl-add-listing-details.png'; ?>" class="epl-welcome-screenshots"/>
					</div>
					
				</div>
			</div>
			<hr>
			
			<div class="changelog headline-feature">
			
				<h2 id="guide-theme" class="epl-welcome-sub-heading"><?php _e( 'Configure your theme', 'epl' );?></h2>
				<h3 class="about-description" style="text-align: center;"><?php _e( 'If you have never looked at a line of code in your life and you can copy and paste you can do this.<br/>We have made this process as easy as possible.', 'epl' );?></h3>

				<div class="feature-section col two-col">

					<div>
						<h4><?php _e( 'Overview', 'epl' );?></h4>
						
						<p><?php _e( 'WordPress has filters and hooks for "the_title" and "the_content" but these are not applicable for real estate websites where the address, price bed/bath icons and maps are much more important than categories, date and published by info.', 'epl' );?></p>
						
						<p><?php _e( 'Not performing the setup steps may cause your sidebar to appear in the wrong place or the listing pages appear too wide.', 'epl' );?></p>
					</div>
					
					<div class="last-feature">
					
						<h4><?php _e( 'Solution', 'epl' );?></h4>

						<p><?php _e( 'All you have to do is duplicate some files and copy and paste into them. If all else fails you can use the included shortcodes but these are not nearly as good as implementing the following steps.</p>
						
						<h4>No Setup Required For These Themes', 'epl' );?></h4>
						<p><a href="http://ithemes.com/member/go.php?r=15200&i=l37">iThemes Builder Theme</a>, Genesis Framework by StudioPress, Twenty 12, 13, 14 &#38; 15 by WordPress.</p>
						
						<p><?php _e( 'We have a selection of pre configured templates here for many popular themes', 'epl' );?> <a href="http://easypropertylistings.com.au/support/forum/theme-support/"><?php _e( 'here', 'epl' );?></a>.</p>
					</div>
				</div>
				
				<div class="feature-section col two-col">

					<div>
						<h4><?php _e( 'Stuck?', 'epl' );?></h4>
						<p><?php _e( 'Not all themes follow WordPress coding standards and these may take a little more time and experience to get working. If you just can not get it to work, visit', 'epl' );?> <a href="http://easypropertylistings.com.au/support/"><?php _e( 'support', 'epl' );?></a> <?php _e( 'desk and fill out a priority request.', 'epl' );?></em></p>
					</div>
					
					<div class="last-feature">
						<h4><?php _e( 'Future', 'epl' );?></h4>
						<p><?php _e( 'We hope a future WordPress release adds filter so this can be automatic, but until that happens you are going to have to perform the following steps using copy and paste.', 'epl' );?></p>
					</div>
				</div>

				
				
			</div>

			
			<div class="changelog headline-feature">
			
				<h3 class="about-description" style="text-align: center;"><?php _e( 'Before attempting the following steps add a', 'epl' );?> <a href="#guide-first-listing"><?php _e( 'test listing', 'epl' );?></a> <?php _e( 'and preview it as your theme may already work with Easy Property Listings.', 'epl' );?></h3>

				<div class="feature-section col two-col">
					<div>
						<h4><?php _e( '1. Take a backup of your theme and a copy of the files to edit.', 'epl' );?></h4>
						
						<p><?php _e( 'Open your favourite FTP program or access the file manager via your hosting panel.', 'epl' );?></p>
						
						<p style="margin-left: 2em;"><em><?php _e( 'Take a backup of your theme before you start.', 'epl' );?></em></p>

						<p><?php _e( 'Download the single.php file and archive.php from your theme folder and save it to your computer.', 'epl' );?></p>
						<p style="margin-left: 2em;"><em><?php _e( 'If these files are not present in your child theme then copy them from your parent theme folder. If there is no archive.php file use the index.php file.', 'epl' );?></em></p>
						
						
						<p><?php _e( 'On your computer rename single.php to single-listing.php and rename archive.php to archive-listing.php', 'epl' );?></p>
						
						<p style="margin-left: 2em;"><em><?php _e( 'If using index.php, rename that to archive-listing.php', 'epl' );?></em></p>

						<p><?php _e( 'Upload these new files back into your theme folder.', 'epl' );?></p>
					</div>
					
					<div class="last-feature">
						<h4><?php _e( '2. Edit your single-listing.php file.', 'epl' );?></h4>
						
						<p><?php _e( 'Open your new single-listing.php file in your text editor like Notepad++.', 'epl' );?></strong></p>
						<p><?php _e( 'Look for', 'epl' );?>:</p>
						<p><strong>&#60;? get_template_part( &#39;SOME_STUFF&#39; , &#39;MORE_STUFF&#39; ); ?&#62;</strong> <?php _e( 'which appears after', 'epl' );?> <strong>the_post();</strong></p>
						<p><?php _e( 'Replace', 'epl' );?>:</p>
							
						<p><strong>&#60;?php get_template_part( &#39;ALL_THE_STUFF&#39; ); ?&#62;</strong></p>
						<p><?php _e( 'with', 'epl' );?></p>
						<p><strong>&#60;?php do_action( &#39;epl_property_single&#39; ); ?&#62;</strong></p>

						<p><?php _e( 'Save the file and make sure you have sent it to the server.', 'epl' );?></p>
						<p><?php _e( 'View the test listing you created and you should be done.', 'epl' );?></p>

					</div>
					
					<div>
						<h4><?php _e( '3. Edit your archive-listing.php file.', 'epl' );?></h4>
						
						<p><?php _e( 'Open archive-listing.php', 'epl' );?></p>
						<p><?php _e( 'Look for', 'epl' );?> &#60;? get_template_part( &#39;SOME_STUFF&#39; , &#39;MORE_STUFF&#39; ); ?&#62; <?php _e( 'which appears after the second', 'epl' );?>  <strong>the_post();</strong></p>
						<p style="margin-left: 2em;"><em><?php _e( 'The first one is usually the page title.', 'epl' );?></em></p>
						
						<p><?php _e( 'Replace', 'epl' );?>:</p>
									
						<p><strong>&#60;?php get_template_part( &#39;ALL_THE_STUFF&#39; ); ?&#62;</strong></p>
						<p>with</p>
						<p><strong>&#60;?php do_action( &#39;epl_property_blog&#39; ); ?&#62;</strong></p>
	
						<p><?php _e( 'Save the file and make sure you have sent it to the server.', 'epl' );?></p>
						<p><?php _e( 'Check the main property page http://YOUR_SITE_URL/property/ and you should be done.', 'epl' );?></p>
							
							
					</div>
					
					<div class="last-feature">
							
						<h4><?php _e( '4. Optional for grid and sorter. Edit your archive-listing.php file again.', 'epl' );?></h4>
						
						<p><?php _e( 'Insert', 'epl' );?> &#60;?php do_action( &#39;epl_property_loop_start&#39; ); ?&#62;</p>
						<p><?php _e( 'Before the second', 'epl' );?> &#60;?php the_post(); ?&#62;</p>
								
						<p><?php _e( 'Check your main property page, if the buttons are in the incorrect place move them until they are in the correct place.', 'epl' );?></p>

						<p><?php _e( 'Insert', 'epl' );?> &#60;?php do_action( &#39;epl_property_loop_end&#39; ); ?&#62;</p>
						<p><?php _e( 'After the second', 'epl' );?> &#60;?php endwhile(); ?&#62;</p>
					
					</div>
					
				</div>
			</div>
			<hr>
			
			<div class="changelog headline-feature">
				<h2 id="guide-help"><?php _e( 'Need Help?', 'epl' );?></h2>
				
				<div class="feature-section col three-col">
					<div>
						<h3 class="about-description" style="text-align: center;"></h3>
						<h4><?php _e( 'Phenomenal Support','epl' );?></h4>
						<p><?php echo $link = sprintf( __( 'We do our best to provide the best support we can. If you encounter a problem or have a question, post a question in the <a href="%s">support forums</a>.', 'epl' ), esc_url( 'http://easypropertylistings.com.au/support/' ) );?></p>
					</div>
					
					<div>
						<h4><?php _e( 'Need Even Faster Support?', 'epl' );?></h4>
						<p><?php _e( 'Visit the <a href="http://easypropertylistings.com.au/support/pricing/">Priority Support forums</a> are there for customers that need faster and/or more in-depth assistance.', 'epl' );?></p>
					</div>
					
					<div class="last-feature">
						<h4><?php _e( 'Documentation and Short Codes','epl' );?></h4>
						<p><?php _e( 'Read the','epl' );?> <a href="http://easypropertylistings.com.au/documentation/"><?php _e( 'documentation','epl' );?></a> <?php _e( ' and instructions on how to use the included','epl' );?> <a href="http://easypropertylistings.com.au/section/short-codes/"><?php _e( 'shortcodes','epl' );?></a>.</p>
					</div>
				</div>	
			</div>	
				
			<div class="changelog headline-feature">

				<div class="feature-section col two-col">
					<div>
						<h3><?php _e( 'Stay Up to Date', 'epl' );?></h3>
						<h4><?php _e( 'Get Notified of Extension Releases','epl' );?></h4>
						<p><?php _e( 'New extensions that make Easy Property Listings even more powerful are released nearly every single week. Subscribe to the newsletter to stay up to date with our latest releases. <a href="http://eepurl.com/TRO9f" target="_blank">Sign up now</a> to ensure you do not miss a release!', 'epl' );?></p>

						<h4><?php _e( 'Get Alerted About New Tutorials', 'epl' );?></h4>
						<p><?php _e( '<a href="http://eepurl.com/TRO9f" target="_blank">Sign up now</a> to hear about the latest tutorial releases that explain how to take Easy Property Listings further.', 'epl' );?></p>
					</div>
					
					<div class="last-feature">
						<h3><?php _e( 'Extend With Extensions', 'epl' );?></h3>
						<h4><?php _e( '12 Extensions and many more coming','epl' );?></h4>
						<p><?php _e( 'Add-on plug ins are available that greatly extend the default functionality of Easy Property Listings. There are extensions for Advanced mapping, testimonials, listing alerts, CMA Market Reports, Location Profiles, and many, many more.', 'epl' );?></p>
						
						<h4><?php _e( 'Visit the Extension Store', 'epl' );?></h4>
						<p><a href="http://easypropertylistings.com.au/extensions/" target="_blank"><?php _e( 'The Extensions store' , 'epl' );?></a> <?php _e( 'has a list of all available extensions, including convenient category filters so you can find exactly what you are looking for.', 'epl' );?></p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', EPL_PROPERTY_VER );
		?>
		<div class="wrap about-wrap epl-about-wrap">
			<h1><?php printf( __( 'Welcome to Easy Property Listings %s', 'epl' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Easy Property Listings %s is ready to make your real estate website faster, safer and better!', 'epl' ), $display_version ); ?></div>
			<div class="epl-badge"><?php printf( __( 'Version %s', 'epl' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<p class="about-description"><?php _e( 'Easy Property Listings is created by a worldwide team of developers who aim to provide the #1 property listings platform for managing your real estate business through WordPress.', 'epl' ); ?></p>

			<?php echo $this->epl_contributors(); ?>
		</div>
		<?php
	}


	/**
	 * Render Contributors List
	 *
	 * @since 1.0
	 * @uses EPL_Welcome::epl_get_contributors()
	 * @return string $contributor_list HTML formatted list of all the contributors for EPL
	 */
	public function epl_contributors() {
		$contributors = $this->get_epl_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
				esc_url( 'https://github.com/' . $contributor->login ),
				esc_html( sprintf( __( 'View %s', 'epl' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}

		$contributor_list .= '</ul>';

		return $contributor_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @since 1.0
	 * @return array $contributors List of contributors
	 */
	public function get_epl_contributors() {
		$contributors = get_transient( 'epl_contributors' );

		if ( false !== $contributors )
			return $contributors;

		$response = wp_remote_get( 'https://api.github.com/repos/easypropertylistings/Easy-Property-Listings/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
			return array();

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) )
			return array();

		set_transient( 'epl_contributors', $contributors, 3600 );

		return $contributors;
	}

	/**
	 * Sends user to the Welcome page on first activation of EPL as well as each
	 * time EPL is upgraded to a new version
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function epl_welcome() {
		// Bail if no activation redirect
		if ( ! get_transient( '_epl_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_epl_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		$upgrade = get_option( 'epl_version_upgraded_from' );

		if( ! $upgrade ) { // First time install
			wp_safe_redirect( admin_url( 'index.php?page=epl-getting-started' ) ); exit;
		} else { // Update
			wp_safe_redirect( admin_url( 'index.php?page=epl-about' ) ); exit;
		}
	}
}
new EPL_Welcome();
