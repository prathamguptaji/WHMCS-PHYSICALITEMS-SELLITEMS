<?php
/**
 * Physical Shipping Provisioning Module for WHMCS
 * * Allows selling physical goods (CDs, Hardware) with Tracking integration.
 *
 * @author      Gemini AI
 * @version     1.0.0
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Database\Capsule;

/**
 * Metadata for the module.
 */
function physical_shipping_MetaData()
{
    return [
        'DisplayName' => 'Physical Goods & Shipping',
        'APIVersion' => '1.1',
        'RequiresServer' => true,
    ];
}

/**
 * Configuration options for the Admin Area.
 */
function physical_shipping_ConfigOptions()
{
    return [
        'Shipping Carrier' => [
            'Type' => 'dropdown',
            'Options' => 'DHL,FedEx,UPS,USPS,Royal Mail,Custom',
            'Description' => 'Select the default carrier.',
        ],
        'Tracking URL Base' => [
            'Type' => 'text',
            'Size' => '50',
            'Default' => 'https://www.google.com/search?q=',
            'Description' => 'Base URL for tracking (e.g., https://www.dhl.com/track?id=). Leave empty if using Google Search.',
        ],
        'Show Address in Client Area' => [
            'Type' => 'yesno',
            'Description' => 'Display the shipping address on the client service page?',
        ],
    ];
}

/**
 * "Create Account" -> "Mark as Shipped"
 * * In the physical goods context, "Provisioning" usually equals "Shipping".
 * When the admin clicks "Create", this runs.
 */
function physical_shipping_CreateAccount(array $params)
{
    try {
        // Logic to perform when marking as shipped.
        // In a real API integration, you might push this to a fulfillment center API here.
        
        // For now, we update a local status or log the action.
        logActivity("Physical Order Shipped: Service ID " . $params['serviceid']);

        return 'success'; // Returning success changes status to Active
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * "Suspend" -> "Order On Hold" / "Return Initiated"
 */
function physical_shipping_SuspendAccount(array $params)
{
    try {
        return 'success';
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * "Terminate" -> "Order Cancelled/Returned"
 */
function physical_shipping_TerminateAccount(array $params)
{
    try {
        return 'success';
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * Client Area Output
 * * This gathers the data to show the tracking UI in the client area.
 */
function physical_shipping_ClientArea(array $params)
{
    // Fetch the Tracking Number from Custom Fields
    // NOTE: You must create a Product Custom Field named "Tracking Number" for the product.
    $trackingNumber = '';
    
    foreach ($params['customfields'] as $name => $value) {
        if (stripos($name, 'tracking') !== false) {
            $trackingNumber = $value;
            break;
        }
    }

    // Determine Carrier Link
    $carrier = $params['configoption1']; // Shipping Carrier
    $baseUrl = $params['configoption2']; // Tracking URL Base
    
    // Auto-generate generic tracking links if Base URL is empty
    if (empty($baseUrl)) {
        switch ($carrier) {
            case 'DHL': $baseUrl = 'https://www.dhl.com/global-en/home/tracking.html?tracking-id='; break;
            case 'FedEx': $baseUrl = 'https://www.fedex.com/fedextrack/?trknbr='; break;
            case 'UPS': $baseUrl = 'https://www.ups.com/track?tracknum='; break;
            case 'USPS': $baseUrl = 'https://tools.usps.com/go/TrackConfirmAction?tLabels='; break;
            default: $baseUrl = 'https://www.google.com/search?q='; break;
        }
    }

    $trackingLink = $trackingNumber ? $baseUrl . $trackingNumber : '#';

    // Get Shipping Address from Client Profile
    $client = $params['clientsdetails'];
    $address = [
        'address1' => $client['address1'],
        'address2' => $client['address2'],
        'city' => $client['city'],
        'state' => $client['state'],
        'postcode' => $client['postcode'],
        'country' => $client['countryname'],
    ];

    return [
        'tabOverviewReplacementTemplate' => 'overview.tpl',
        'templateVariables' => [
            'trackingNumber' => $trackingNumber,
            'carrier' => $carrier,
            'trackingLink' => $trackingLink,
            'shippingAddress' => $address,
            'status' => $params['status'], // Pending, Active (Shipped), etc.
            'showAddress' => $params['configoption3'],
        ],
    ];
}

/**
 * Admin Area Output
 * * Shows a quick status widget in the Admin Service view.
 */
function physical_shipping_AdminServicesTabFields(array $params)
{
    // Fetch Tracking from Custom Fields
    $trackingNumber = 'Not Set';
    foreach ($params['customfields'] as $name => $value) {
        if (stripos($name, 'tracking') !== false) {
            $trackingNumber = $value;
            break;
        }
    }

    return [
        'Current Tracking' => $trackingNumber,
        'Shipment Status' => $params['status'],
    ];
}