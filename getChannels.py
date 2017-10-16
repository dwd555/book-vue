from urllib import request
import xml.sax
pXml='<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><s:Body><u:Browse xmlns:u="urn:schemas-upnp-org:service:ContentDirectory:1"><ObjectID>0</ObjectID><BrowseFlag>BrowseDirectChildren</BrowseFlag><Filter></Filter><StartingIndex>0</StartingIndex><RequestedCount>200</RequestedCount><SortCriteria></SortCriteria></u:Browse></s:Body></s:Envelope>'
url="http://192.168.1.202:58071/ContentDirectory/ee604a52-fc5d-5575-b03d-9d2cea1ddb39/control.xml"
req = request.Request(url)
req.add_header("SOAPACTION", "urn:schemas-upnp-org:service:ContentDirectory:1#Browse")
req.add_header("Content-Type", "text/xml;charset='utf-8'")
with request.urlopen(req, data=pXml.encode('utf-8')) as f:
    print('Status:', f.status, f.reason)
    for k, v in f.getheaders():
        print('%s: %s' % (k, v))
    #print('Data:', f.read().decode('utf-8'))
    print(f.read().decode('utf-8'))
