<?php
$configFile = 'config.json';
if (isset($configFile)) {

    if (file_exists($configFile)) {

        $configData = json_decode(file_get_contents($configFile), true);

        if ($configData === null) {
            die('Error decoding JSON in config file.');
        }

    } else {
        die('Config file not found.');
    }

    if (isset($configData)) {

        $options = [

            'requestType' => 'code',

            'redirectUri' => 'http://161.35.103.238/getAccessToken.php',

            'clientId' => $configData['clientId'],

            'scopes' => [
'businesses.readonly',
'companies.readonly',
'calendars.readonly',
'calendars/events.readonly',
'calendars/groups.readonly',
'calendars/resources.readonly',
'campaigns.readonly',
'conversations.readonly',
'conversations/message.readonly',
'conversations/reports.readonly',
'contacts.readonly',
'objects/schema.readonly',
'objects/record.readonly',
'associations.readonly',
'associations/relation.readonly',
'courses.readonly',
'forms.readonly',
'invoices.readonly',
'invoices/schedule.readonly',
'invoices/template.readonly',
'invoices/estimate.readonly',
'links.readonly',
'lc-email.readonly',
'locations.readonly',
'locations/customValues.readonly',
'locations/customFields.readonly',
'locations/tasks.readonly',
'locations/tags.readonly',
'locations/templates.readonly',
'medias.readonly',
'funnels/redirect.readonly',
'funnels/page.readonly',
'funnels/funnel.readonly',
'funnels/pagecount.readonly',
'oauth.readonly',
'opportunities.readonly',
'payments/orders.readonly',
'payments/integration.readonly',
'payments/transactions.readonly',
'payments/subscriptions.readonly',
'payments/coupons.readonly',
'payments/custom-provider.readonly',
'products.readonly',
'products/prices.readonly',
'products/collection.readonly',
'saas/company.read',
'saas/location.read',
'snapshots.readonly',
'socialplanner/oauth.readonly',
'socialplanner/post.readonly',
'socialplanner/account.readonly',
'socialplanner/csv.readonly',
'socialplanner/category.readonly',
'socialplanner/tag.readonly',
'store/shipping.readonly',
'store/setting.readonly',
'surveys.readonly',
'users.readonly',
'workflows.readonly',
'emails/builder.readonly',
'emails/schedule.readonly',
'wordpress.site.readonly',
'blogs/check-slug.readonly',
'blogs/category.readonly',
'blogs/author.readonly',
'custom-menu-link.readonly',
'blogs/posts.readonly',
'blogs/list.readonly'

]
        ];

        $redirectUrl = $configData['baseUrl'] . '/oauth/chooselocation?' . http_build_query([
            'response_type' => $options['requestType'],
            'redirect_uri' => $options['redirectUri'],
            'client_id' => $options['clientId'],
            'scope' => implode(' ', $options['scopes'])
        ]);

        header("Location: $redirectUrl");

    } else {
        echo "ERROR: config Data is not found";
    }
} else {
    echo "ERROR: please insert config file";
}
