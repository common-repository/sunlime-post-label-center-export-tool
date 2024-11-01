#PLC Manager
Das Plugin ermöglicht den Export von Bestellung von WooCommerce in das Post Label Center. Dabei wird bei erfolgreichem 
Export die Versandnummern gespeichert und bei der jweiligen Bestellung angezeigt. 

##Daten
Es werden lediglich die Adressdaten des Users & die eingegeben Versenderdaten an das PLC gesendet. 

##Demo Daten
Um die Verbindung zu testen können folgende Daten verwendet werden: 

###API Daten
```
ClientID:       -1
OrgUnitID:      1461448
OrgUnitGUID:    cd96848d-6552-4653-a992-f0f411710fb4
```

###WSDL
```
https://abn-plc.post.at/DataService/Post.Webservice/ShippingService.svc?wsdl
```

Website: https://abn-plc.post.at

Username: demo

Passwort: demo

###zippen
```zip -r plc.zip plc_export -x "*.DS_Store" -x "*.git*"```