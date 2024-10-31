<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 04.03.2019
 * Time: 10:27
 */
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/appearancesection/IvpmbAppearanceSection.php';
if (file_exists( dirname(IVPMB_SPINNER_IMPROVED) . '/engine/stylingsection/StylingSection.php')) {
	require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/stylingsection/StylingSection.php';
}

class IvpmbAdmin {
	private $appearanceSection;
    private $optionalSections;

	public static function init() {
		if (file_exists( dirname(IVPMB_SPINNER_IMPROVED) . '/engine/stylingsection/StylingSection.php')) {
			return new IvpmbAdmin([ 'iv_styling_section_tab' => new StylingSection()]);
		}
		return new IvpmbAdmin();
    }

	public function __construct($optionalSections = []) {
        $this->optionalSections = $optionalSections;
        $this->initTextdomain();
		$this->appearanceSection = new IvpmbAppearanceSection();
		add_action('admin_menu', [$this, 'settingsMenu']);
		add_action('admin_init', [$this, 'settingsInit']);
		$plugin = plugin_basename(IVPMB_SPINNER_IMPROVED);
		add_filter("plugin_action_links_$plugin", [$this, 'applySettingsLink']);
	}

	public function initTextdomain() {
		$textdomain = basename(dirname(IVPMB_SPINNER_IMPROVED)) . '/languages';
		//this only works with the deprecated parameter...
		load_plugin_textdomain('plus-minus-button', false, $textdomain);
	}

	public function settingsMenu() {
		$capability = 'manage_options';
		$menu_slug = 'iv_spinner_options';
		$page_title = __('iv-spinner-options-title', 'plus-minus-button');
		$menu_title = __('iv-spinner-options-title', 'plus-minus-button');
		$function = [$this, 'settingsPage'];
		add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
	}

	public function settingsPage() {
		if(isset($_GET['tab'])) {
			$active_tab = $_GET['tab'];
		} else {
			$active_tab = 'iv_appearance_section_tab';
		}

		?>
		<div class="icon32" id="icon-options-general"><br></div>
		<h2 class="iv-spinner-options-title"><?php _e('iv-spinner-options-title', 'plus-minus-button')?></h2>
		<?php _e('iv-spinner-options-slug', 'plus-minus-button')?><br>
        <?php if (count($this->optionalSections) > 0) {?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=iv_spinner_options&tab=iv_appearance_section_tab" class="nav-tab <?php echo $active_tab == 'iv_appearance_section_tab' ? 'nav-tab-active' : ''; ?>">
				<?php _e('iv-appearance-section-tab', 'plus-minus-button')?>
            </a>
            <?php $this->applySectionTabs($active_tab);?>
        </h2>
        <?php } ?>
        <div id="iv-spinner-form-container" class="wrap">
			<form action="options.php" method="post" enctype="multipart/form-data">
				<?php
				if ($active_tab === 'iv_appearance_section_tab' || count($this->optionalSections) == 0) {
					$this->appearanceSection->output();
				} else {
				    if ($this->optionalSections[$active_tab] != null) {
					    $this->optionalSections[ $active_tab ]->output();
				    }
				}
				?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	public function applySectionTabs($active_tab) {
	    foreach($this->optionalSections as $currentTab => $section) {
		    $activeTab  = $active_tab == $currentTab ? 'nav-tab-active' : '';
		    $caption    = __( IvpmbAdminCore::applyDashes( $currentTab ), 'plus-minus-button' );
		    printf( '<a href="?page=iv_spinner_options&tab=%s" class="nav-tab %s">%s</a>', $currentTab, $activeTab, $caption );
	    }
	}

	public function applySettingsLink($actions) {
	    $url = admin_url('options-general.php?page=iv_spinner_options');
	    $slug = __('iv-spinner-settings', 'plus-minus-button');
		$actions[] = sprintf('<a href="%s">%s</a>', $url, $slug);
		return $actions;
	}

	public function settingsInit() {
		$this->appearanceSection->settingsInit();
		foreach($this->optionalSections as $currentTab => $section) {
			$section->settingsInit();
		}
	}

	public function isActiveOnShopPage() {
		return $this->appearanceSection->isActiveOnShopPage();
	}

	public function isActiveOnCartPage() {
	    return $this->appearanceSection->isActiveOnCartPage();
    }

    public function isActiveOnSingleProductPage() {
	    return $this->appearanceSection->isActiveOnSingleProductPage();
    }
}