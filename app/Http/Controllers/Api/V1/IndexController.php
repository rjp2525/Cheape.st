<?php

namespace Cheapest\Http\Controllers\Api\V1;

use Cheapest\Http\Controllers\Controller;
use Cheapest\Http\Requests;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Return a generic response for now.
     * TODO: Turn this into some API docs or something?
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['error' => true, 'message' => 'Invalid API token']);
    }

    public function test()
    {
        $json = [
            [
                'title'             => 'Duracell - AAA Batteries (4-Pack)',
                'description_short' => 'Compatible with select electronic devices; AAA size; DURALOCK Power Preserve technology; 4-pack',
                'description_long'  => 'Power a variety of electronic devices with these Duracell MN2400B4Z AAA batteries that come in a 4-pack to ensure you have extras on hand.',
                'price'             => 5.49,
                'url'               => 'http://www.bestbuy.com/site/duracell-aaa-batteries-4-pack/43900.p?id=1051384074145&skuId=43900&cmp=RMX',
                'cart_url'          => 'http://www.bestbuy.com/site/olspage.jsp?id=pcmcat152200050035&type=category&cmp=RMX&qvsids=43900',
                'provider'          => 'bestbuy'
            ],
            [
                'title'             => 'Nickelodeon Paw Patrol On-the-Go Folding Slumber Set',
                'description_short' => 'Sized just right for little ones, this Disney On-the-Go Folding Slumber Set will be the center of attention at the next sleepover. Your child can take bedtime adventure almost anywhere with its convenient, folding structure. The removable slumber sack also makes it easy to clean. The On-the-Go Folding Slumber Set can be used indoors or outdoors.',
                'description_long'  => '&lt;br&gt;&lt;b&gt;Nickelodeon Paw Patrol On-the-Go Folding Slumber Set:&lt;/b&gt;&lt;ul&gt;&lt;li&gt;Unique graphics featuring your favorite Paw Patrol characters&lt;/li&gt;&lt;li&gt;Fold easily; great for traveling and space saving&lt;/li&gt;&lt;li&gt;Indoor and outdoor use&lt;/li&gt;&lt;li&gt;Removable slumber sack for easy clean-up&lt;/li&gt;&lt;li&gt;Slumber sack is 100 percent polyester&lt;/li&gt;&lt;li&gt;Dimensions: 30&quot;W x 57&quot;L&lt;/li&gt;&lt;/ul&gt;&lt;br&gt;&lt;b&gt;Questions about product recalls?&lt;/b&gt;&lt;br&gt;Items that are a part of a recall are removed from the Walmart.com site, and are no longer available for purchase. These items include Walmart.com items only, not those of Marketplace sellers. Customers who have purchased a recalled item will be notified by email or by letter sent to the address given at the time of purchase. For complete recall information, go to &lt;a href=&quot;%201Dhttp://walmartstores.com/Recalls/%201D&quot; target=&quot;&rdquo;_blank&rdquo;&quot;&gt;Walmart Recalls&lt;/a&gt;.',
                'price'             => 29.98,
                'url'               => 'http://c.affil.walmart.com/t/api01?l=http%3A%2F%2Fwww.walmart.com%2Fip%2FNickelodeon-Paw-Patrol-On-the-Go-Folding-Slumber-Set%2F42120600%3Faffp1%3D%7Capk%7C%26affilsrc%3Dapi%26veh%3Daff%26wmlspartner%3Dreadonlyapi',
                'cart_url'          => 'http://c.affil.walmart.com/t/api01?l=http%3A%2F%2Faffil.walmart.com%2Fcart%2FaddToCart%3Fitems%3D42120600%7C1%26affp1%3D%7Capk%7C%26affilsrc%3Dapi%26veh%3Daff%26wmlspartner%3Dreadonlyapi',
                'provider'          => 'walmart'
            ]
        ];

        return response()->json($json);
    }
}
