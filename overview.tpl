<!-- 
    Place this file in: /modules/servers/physical_shipping/templates/overview.tpl 
-->

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-box-open"></i> Shipment Details</h3>
            </div>
            <div class="panel-body text-center">
                <h4>{$carrier}</h4>
                <div class="status-badge" style="margin: 15px 0;">
                    {if $status eq 'Active'}
                        <span class="label label-success" style="font-size: 1.2em; padding: 5px 10px;">SHIPPED</span>
                    {elseif $status eq 'Pending'}
                        <span class="label label-warning" style="font-size: 1.2em; padding: 5px 10px;">PROCESSING</span>
                    {else}
                        <span class="label label-default" style="font-size: 1.2em; padding: 5px 10px;">{$status}</span>
                    {/if}
                </div>
                
                <hr>

                {if $trackingNumber}
                    <p class="text-muted">Tracking Number</p>
                    <div class="well well-sm" style="font-family: monospace; font-size: 1.2em; letter-spacing: 1px;">
                        {$trackingNumber}
                    </div>
                    <a href="{$trackingLink}" target="_blank" class="btn btn-primary btn-block">
                        <i class="fas fa-truck"></i> Track Package
                    </a>
                {else}
                    <div class="alert alert-info">
                        <i class="fas fa-clock"></i> Tracking number will appear here once shipped.
                    </div>
                {/if}
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-gamepad"></i> Item Information</h3>
            </div>
            <div class="panel-body">
                <h3>{$product}</h3>
                <p class="lead">{$groupname}</p>

                {if $showAddress}
                    <hr>
                    <h4><i class="fas fa-map-marker-alt"></i> Shipping To:</h4>
                    <address style="font-size: 1.1em; margin-left: 20px;">
                        <strong>{$shippingAddress.address1}</strong><br>
                        {if $shippingAddress.address2}{$shippingAddress.address2}<br>{/if}
                        {$shippingAddress.city}, {$shippingAddress.state} {$shippingAddress.postcode}<br>
                        {$shippingAddress.country}
                    </address>
                {/if}

                <div class="alert alert-warning" style="margin-top: 20px;">
                    <strong><i class="fas fa-info-circle"></i> Need Help?</strong><br>
                    If your item arrives damaged or the tracking is not updating after 48 hours, please open a support ticket immediately.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Optional quick styling adjustments */
    .panel-default { border-color: #ddd; }
    .label-success { background-color: #5cb85c; }
    .label-warning { background-color: #f0ad4e; }
</style>