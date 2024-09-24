=== Facturare WooCommerce ===
Contributors: giucu91
Tags: woocommerce, facturare, persoana fizica, persoana juridica
Requires at least: 3.5
Tested up to: 6.6
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Adaugă câmpurile necesare facturării persoanelor fizice sau juridice conform legislației din Romania în vigoare.

== Description ==

Datorită legislației în vigoare din România fiecare magazin online trebuie să aibă anumite informații pe factură. Acest modul vine în ajutorul tau si te ajuta sa adaugi respectivele informații mai ușor.

Pentru persoanele fizice poți adăuga:
	- CNP

Pentru persoanele juridice poți adăuga::
	- CUI
	- Nr. Registru Comertului
	- Nume Banca
	- IBAN

**Acest plugin nu emite facturi, el doar adaugă câmpurile necesare unei facturi pe pagina de checkout.**

Pentru mai multe informații vizitați [Modul Facturare](https://avianstudio.com/plugin/facturare-for-woocommerce/?utm_source=wporg&utm_medium=woofacturare&utm_campaign=upsell)

[Facturare PRO for WooCommerce](https://avianstudio.com/plugin/woocommerce-facturare-pro/?utm_source=wporg&utm_medium=woofacturarepro&utm_campaign=upsell) oferă următoarele funcționalități: clienții pot vizualiza prețurile produselor, inclusiv cu sau fără TVA, și sistemul se adaptează automat la legislația în vigoare privind taxarea diferită în funcție de tipul de cumpărător, un exemplu in acest sens ar fi taxele pentru sistemele fotovoltaice.

Vreti sa emiteti facturi/proforme cu SmartBill ? Nu a fost niciodata mai simplu ! Cu ajutorul pluginului nostru [SmartBill for WooCommerce](https://avianstudio.com/?utm_source=wporg&utm_medium=woosmartbill&utm_campaign=upsell) puteti automatiza procesul de facturare.

Poți automatiza preluarea informațiilor despre companii în funcție de CUI, pentru mai multe detalii vezi : [OpenAPI for WooCommerce](https://avianstudio.com/?utm_source=wporg&utm_medium=wooopenapi&utm_campaign=upsell)


== Installation ==

Please see [Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins) in the WordPress Codex.

Dupa activare, du-te la *WooCommerce > Settings > Facturare*

== Frequently Asked Questions ==

= Cum iau informațiile din baza de date ? =

Pentru a optimiza baza de date, câmpurile adăugate de acest plugin sunt salvate într-un singur rând in baza de date în loc de 5. În tabela wp_postmeta, având key-ul 'av_facturare'. Din cauza asta nu este ușoară preluarea din baza de date a informației, așa că am făcut următoarele key-uri, care nu se găsesc în baza de date, dar o să vă returneze valoarea dorită.

`$cnp = get_post_meta( $order_id, '_billing_facturare_cnp', true );`
`$nr_reg_com = get_post_meta( $order_id, '_billing_facturare_nr_reg_com', true );`
`$cui = get_post_meta( $order_id, '_billing_facturare_cui', true );`
`$nume_banca = get_post_meta( $order_id, '_billing_facturare_nume_banca', true );`
`$iban = get_post_meta( $order_id, '_billing_facturare_iban', true );`

== Screenshots ==

1. Setări Generale
2. Setări Persoane Fizice
3. Setări Persoane Juridice

== Changelog ==

** 1.2.1 **
- Compatibility: Compatibilitate cu pluginul oficial SmartBill Facturare si Gestiune

** 1.2.1 **
- Fix: Transmiterea datelor de facturare cand se creaza o noua comanda din dashboardul adminului si este ales un client existent
- Added: Optiune de a nu valida CUI-ul pentru magazinele care au clienti si din afara Romaniei

** 1.2.0 **
- Reparat campurile speciale
- integrare HPOS de la WooCommerce
- integrare cu Oblio

** 1.1.3 **
- Adaugat wpml-config.xml pentru a putea traduce optiunile din plugin.

** 1.1.2 **
- Reparat validarea codul IBAN.

** 1.1.1 **
- Reparat integrarea cu WooCommerce SmartBill

** 1.1.0 **
- Adaugarea posibilitatii de a edita informatii de facturare din admin din comanda
- Validarea campurilor de CNP / CUI / IBAN
- Imbunatatit compatibilitatea cu pluginurile de tip Checkout Field Editor
- adaugare compatibilitate cu Advanced Order Export For WooCommerce ( https://wordpress.org/plugins/woo-order-export-lite/ )

** 1.0.8 **
- Integrare cu WooCommerce PDF Invoice (https://codecanyon.net/item/woocommerce-pdf-invoice/5951088)
- Campul CNP nu mai e obligatoriu
- Integrare cu WooCommerce SmatBill

** 1.0.7 **
- Stilizat fieldul de tip facturare

** 1.0.6 **
- Integrarea cu pluginuri pentru modificarea câmpurilor de pe pagina de checkout ( Checkout Field Editor for WooCommerce / Flexible Checkout Fields )
- Adăugarea de funcții pentru a prelua informațiile din baza de date.

** 1.0.5 **
- Adăugarea unui formular de feedback
- Rezolvat incompatibilitatea cu CartFlow plugin.

** 1.0.4 **
- Added return in 'woocommerce_get_settings_pages' filter.
- Added compatibility with WooCommerce Admin

** 1.0.3 **
- Fixed undefined index.

** 1.0.2 **
- Fixed optional/required in translated WooCommerce.

** 1.0.1 **
- Fixed error on orders admin page.

** 1.0 **
- Initial release