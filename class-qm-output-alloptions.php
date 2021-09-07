<?php
/**
 * Output class
 *
 * Class QM_Output_AllOptions
 */
class QM_Output_AllOptions extends QM_Output_Html {

	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );
		add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );
		// add_filter( 'qm/output/title', array( $this, 'admin_title' ), 101 );
		add_filter( 'qm/output/menu_class', array( $this, 'admin_class' ) );
	}

	/**
	 * Outputs data in the footer
	 */
	public function output() {
		$data = $this->collector->get_data();
		?>
		<div class="qm qm-non-tabular" id="<?php echo esc_attr($this->collector->id())?>">
			<div class="qm-boxed">
			<?php
			printf(
				'Total size: <strong>%s</strong> (uncompressed), %s (estimated compression)',
				size_format( $data['total_size'], 2 ),
				size_format( $data['total_size_comp'], 2 )
			);
			?>
			</div>
			<table class="qm-sortable">
				<thead>
					<tr>
					<th scope="col"><?php esc_html_e( 'Option name', 'qm-monitor' ); ?></th>
					<th scope="col"><?php esc_html_e( 'Size (bytes)', 'qm-monitor' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ( $data['options'] as $option ) {
						echo '<tr>';
						printf( '<td class="qm-ltr">%s</td><td class="qm-ltr">%d</td>', $option->name, $option->size );
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
		<ul>
		<li>use <code>wp option get &lt;option_name&gt;</code> to view a big option</li>
		<li>use <code>wp option delete &lt;option_name&gt;</code> to delete a big option</li>
		<li>use <code>wp option autoload set &lt;option_name&gt; no</code> to disable autoload for option</li>
		</ul>
		</div>
		<?php
	}

	/**
	 * Adds data to top admin bar
	 *
	 * @param array $title
	 *
	 * @return array
	 */
	public function admin_title( array $title ) {
		// $data = $this->collector->get_data();

		$title[] = sprintf(
			_x( '%s<small>F</small>', 'number of included files', 'query-monitor' ),
			'x'
		);

		return $title;
	}

	/**
	 * @param array $class
	 *
	 * @return array
	 */
	public function admin_class( array $class ) {
		$class[] = 'qm-alloptions';
		return $class;
	}

	public function admin_menu( array $menu ) {

		// $data = $this->collector->get_data();

		$menu[] = $this->menu( array(
			'id'    => 'qm-alloptions',
			'href'  => '#qm-alloptions',
			'title' => __( 'AllOptions', 'query-monitor' ),
		));

		return $menu;
	}
}