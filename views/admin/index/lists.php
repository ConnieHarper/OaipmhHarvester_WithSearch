<?php
/**
 * Admin sets view.
 * 
 * @package OaipmhHarvester
 * @subpackage Views
 * @copyright Copyright (c) 2009 Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */
$head = array('body_class' => 'oaipmh-harvester primary', 
              'title'      => 'OAI-PMH Harvester | Harvest Records');
head($head);
?>

<h1><?php echo $head['title']; ?></h1>

<div id="primary">

    <?php echo flash(); ?>

    <?php if (empty($this->availableMaps)): ?>
    <div class="error">There are no available data maps that are compatable with 
    this repository. You will not be able to harvest from this repository.</div>
    <?php endif; ?>
    
    <h2>Data provider: <?php echo $this->baseUrl; ?></h2>
    <h3>Harvest all records found:</h3>
    <p>
    <form method="post" action="<?php echo uri('oaipmh-harvester/index/harvest'); ?>">
        <?php //echo $this->formSelect('metadata_spec', null, null, $this->availableMaps); ?>
        <?php echo $this->formHidden('base_url', $this->baseUrl); ?>
        <?php echo $this->formHidden('set_spec', $this->setSpec); ?>
        <?php echo $this->formHidden('set_name', $this->setName); ?>
        <?php echo $this->formHidden('search_text', $this->searchText); ?>
        <?php echo $this->formHidden('metadata_spec', $this->metadataSpec); ?>
        <?php echo $this->formHidden('metadata_class', $this->metadataClass); ?>
        <?php echo $this->formHidden('metadata_prefix', $this->metadataPrefix); ?>
        <?php echo $this->formSubmit('submit_harvest', 'Harvest all Records'); ?>
    </form>
    <br />
    </p>
    
    <h3>Harvest a set:</h3>
    <table>
        <thead>
            <tr>
                <th>Record Spec</th>
                <th>Record Name</th>
                <th>Record Description</th>
                <th>Harvest</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($this->records as $record): ?>
    <?php $recordDc = @ $record->metadata->children($this->metadataPrefix, true)->children('dc', true); ?>
<?php /*
	$handle = fopen( '/var/www/html/dev/cfmi/omeka/trunk/archive/log.txt','a');
	fwrite ($handle, "Inside the VIEW\n");	
	fwrite ($handle, print_r($this->records,true));	
	fwrite ($handle, "\nrecord".print_r($record, true));	
	fwrite ($handle, "\nrecordDc".print_r($recordDc, true));	
	fclose($handle);*/
	?>
            <tr>
                <td><strong><?php echo wordwrap($record->header->setSpec, 20, '<br />', true); ?></strong></td>
                <?php //echo "<td class='toggle-next'>".$record->header->identifier."</td><td><div class='toggle-content'>this is the content </div></td>"; ?>
                <td class='toggle-next'><?php echo $recordDc->title; ?></td>
                <td class='toggle-content'><?php echo $recordDc->description; ?></td>
                <td><form method="post" action="<?php echo uri('oaipmh-harvester/index/harvest'); ?>">
        	<?php //echo $this->formSelect('metadata_spec', null, null, $this->availableMaps); ?>
        	<?php echo $this->formHidden('metadata_spec', $this->metadataSpec); ?>
        	<?php echo $this->formHidden('metadata_class', $this->metadataClass); ?>
        	<?php echo $this->formHidden('metadata_prefix', $this->metadataPrefix); ?>
                <?php echo $this->formHidden('base_url', $this->baseUrl); ?>
                <?php echo $this->formHidden('set_spec', $this->setSpec); ?>
                <?php echo $this->formHidden('record_identifier', $record->header->identifier); ?>
                <?php echo $this->formHidden('set_name', $this->setName); ?>
                <?php echo $this->formSubmit('submit_harvest', 'Harvest'); ?>
                </form></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($this->resumptionToken): ?>
    <div>
        <form method="post">
            <?php echo $this->formHidden('base_url', $this->baseUrl); ?>
            <?php echo $this->formHidden('resumption_token', $this->resumptionToken); ?>
            <?php echo $this->formSubmit('submit_next_page', 'Next Page'); ?>
        </form>
    </div>
    <?php endif; ?>
    <?php /*endif;*/?>
</div>

<?php foot(); ?>
