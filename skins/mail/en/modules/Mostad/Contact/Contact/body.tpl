<p>
    <b>{t(#Submitted Page#)}:</b> {data.page-title}<br/>
</p>
<p>
    <b>{t(#Name#)}:</b> {data.name}<br/>
    <b>{t(#Firm Name#)}:</b> {data.firmName}<br/>
    <b>{t(#E-mail#)}:</b> {data.email}<br/>
    <b>{t(#Phone#)}:</b> {data.phone}<br/>
    <b>{t(#Address#)}:</b> {data.address}<br/>
    <b>{t(#Address 2#)}:</b> {data.address2}<br/>
    <b>{t(#City#)}:</b> {data.city}<br/>
    <b>{t(#State#)}:</b> {getStateName(data.state)}<br/>
    <b>{t(#Zip#)}:</b> {data.zipcode}<br/>
    <b>{t(#Firm Type#)}:</b> {data.firmType}<br/>
    <b>{t(#Firm Type (Other)#)}:</b> {data.firmTypeOther}<br/>
    <b>{t(#In Public Practice#)}:</b> {data.publicPractice}<br/>
    <b>{t(#Source#)}:</b> {data.source}<br/>
</p>
<p>
    <b>Message:</b><br/>
    {data.message:nl2br}
</p>