<?=
'<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>{{$category->name}}</title>
        <link>http://www.rhust.app.com/shop/{{$category->id}}</link>
        <description>{{$category->description}}</description>      
        @foreach($products as $product)
        <item>
            <g:id>{{$product->id}}</g:id>
            <g:title>{{$product->name}}</g:title>
            <g:description>{{$product->description}}</g:description>
            <g:link>http://www.rhust.app.com/product/{{$product->id}}</g:link>
            <g:image_link>http://www.rhust.app.com{{$product->photo}}</g:image_link>
            <g:condition>New</g:condition>
            <g:availability>in stock</g:availability>
            <g:price>{{$product->price}} USD</g:price>
            <g:shipping>
                <g:country>VN</g:country>
                <g:service>Standard</g:service>
                <g:price>30.000 vnđ</g:price>
            </g:shipping>

            <g:gtin>{{$product->product_code}}</g:gtin>
            <g:brand>{{$product->brand->name}}</g:brand>
           
            <g:google_product_category>{{$cate_gg->gg_category}}</g:google_product_category>
        </item>
        @endforeach
    </channel>
</rss>