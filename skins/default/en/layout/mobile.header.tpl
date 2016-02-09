{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Mobile header
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="mobile_header">
  <ul class="nav nav-pills">
    <li class="dropdown">
      <a id="main_menu" href="#slidebar">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
          <path d="M1.9,15.5h16.2v-1.8H1.9V15.5z M1.9,11h16.2V9.2H1.9V11z M1.9,4.7v1.8h16.2V4.7H1.9z"/>
        </svg>
      </a>
      <div id="top-menu" class="dropdown-menu">
        <list name="header.menu" />
      </div>
    </li>
    <li class="dropdown">
      <a id="search_menu" class="dropdown-toggle" data-toggle="dropdown" href="#">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
            <path d="M13.5,12.2h-0.7l-0.3-0.3c0.9-1.1,1.5-2.5,1.5-4c0-3.4-2.7-6.1-6.1-6.1C4.5,1.9,1.8,4.6,1.8,8c0,3.4,2.7,6.1,6.1,6.1
	c1.5,0,2.9-0.6,4-1.5l0.3,0.3v0.7l4.7,4.7l1.4-1.4L13.5,12.2z M7.9,12.2c-2.3,0-4.2-1.9-4.2-4.2c0-2.3,1.9-4.2,4.2-4.2
	c2.3,0,4.2,1.9,4.2,4.2C12.1,10.3,10.2,12.2,7.9,12.2z"/>
          </svg>
      </a>
      <ul id="search_box" class="dropdown-menu" >
        <li role="presentation">
          <list name="layout.responsive.search" />
        </li>
      </ul>
    </li>
    <li class="dropdown">
      <a id="account_menu" class="dropdown-toggle" data-toggle="dropdown" href="#">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="230 250 20 20" enable-background="new 230 250 20 20" xml:space="preserve">
            <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)">
                <path d="M2391.6,2479.3c-9-1.3-15.5-4.2-20.4-9c-4.5-4.5-6.6-8.6-8-15.5c-1.2-6.3-0.5-17.6,1.8-26.5c1-3.7,0.9-3.8-0.3-5.2
                    c-1.5-1.7-2-3.4-1.8-6.6c0.4-5.2,2.6-9.4,5.6-10.9c1.2-0.6,1.8-1.1,1.8-1.5c0-4,5.8-15.7,8.7-17.7c0.8-0.5,0.8-0.8,0.6-8.7
                    c-0.2-9.7-0.2-9.9-4.3-13.7c-3-2.8-8.7-5.7-17.5-8.9c-8.8-3.2-12.8-4.9-17-7c-9.7-4.9-15.6-10.5-18.5-17.9c-1.1-2.6-2.1-7-2.1-8.8
                    v-1.1h79.8h79.8l-0.2,1.8c-1,7.9-4.5,14.4-10.6,19.8c-4.6,4-11.7,7.6-24.4,12.3c-14.6,5.5-20.3,8.8-23.1,13.5c-1,1.8-1,1.8-1.1,9.9
                    l-0.2,8.1l1.5,1.6c3,3.2,6.2,9.7,7.4,15.1c0.6,2.4,0.7,2.6,2.1,3.2c2.8,1.2,4.7,4.6,5.6,9.8c0.6,3.2,0,5.8-1.7,7.7l-1.2,1.4
                    l1.3,4.7c1.9,6.9,2.4,10.4,2.7,16.8c0.3,8.6-0.8,13.3-4.3,18.7c-2.6,4-7.2,6.9-12.3,8c-1.9,0.4-2.6,0.8-4.1,2.2
                    c-2,1.9-4.7,3.3-8.2,4.2C2405.6,2479.8,2396.4,2480,2391.6,2479.3z"/>
            </g>
           </svg>
      </a>
      <ul id="account_box" class="dropdown-menu">
        <li role="presentation">
          <list name="layout.responsive.account" />
        </li>
      </ul>
    </li>

    <li class="dropdown" IF="{isNeedLanguageDropDown()}">
      <a id="language_menu" class="dropdown-toggle" data-toggle="dropdown" href="#">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="-8 12 20 20" enable-background="new -8 12 20 20" xml:space="preserve">
              <path display="none" fill="none" d="M-8,12h20v20H-8V12z"/>
              <path d="M2,13.7c-4.6,0-8.3,3.7-8.3,8.3s3.7,8.3,8.3,8.3c4.6,0,8.3-3.7,8.3-8.3S6.6,13.7,2,13.7z M7.8,18.7H5.3c-0.3-1-0.6-2-1.2-3
	C5.7,16.2,7,17.3,7.8,18.7z M2,15.4c0.7,1,1.2,2.1,1.6,3.3H0.4C0.8,17.5,1.3,16.4,2,15.4z M-4.4,23.7c-0.1-0.5-0.2-1.1-0.2-1.7
	s0.1-1.1,0.2-1.7h2.8c-0.1,0.5-0.1,1.1-0.1,1.7s0,1.1,0.1,1.7H-4.4z M-3.8,25.3h2.5c0.3,1,0.6,2,1.2,3C-1.7,27.8-3,26.7-3.8,25.3z
	 M-1.3,18.7h-2.5c0.8-1.4,2.1-2.4,3.6-3C-0.7,16.6-1,17.6-1.3,18.7z M2,28.6c-0.7-1-1.2-2.1-1.6-3.3h3.2C3.2,26.5,2.7,27.6,2,28.6z
	 M4,23.7H0C0,23.1-0.1,22.6-0.1,22S0,20.9,0,20.3H4C4,20.9,4.1,21.4,4.1,22S4,23.1,4,23.7z M4.2,28.3c0.5-0.9,0.9-1.9,1.2-3h2.5
	C7,26.7,5.7,27.8,4.2,28.3z M5.6,23.7c0.1-0.5,0.1-1.1,0.1-1.7s0-1.1-0.1-1.7h2.8c0.1,0.5,0.2,1.1,0.2,1.7s-0.1,1.1-0.2,1.7H5.6z"/>
           </svg>
      </a>
      <ul id="language_box" class="dropdown-menu">
        <li role="presentation">
            <ul class="language_list">
                <list name="header.language.menu" />
            </ul>
        </li>
      </ul>
    </li>
    <list name="layout.header.mobile.menu" />
  </ul>
</div>
