"""
This example script will login to the API and obtain
a session id.
@copyright  Copyright (c) 2018 Bronto Software
"""

import sys
import logging
from suds.client import Client
from suds import WebFault

# Bronto API WSDL
BRONTO_WSDL = 'https://api.bronto.com/v4?wsdl'

# start up basic logging
logging.basicConfig()

# Replace the placeholder text with a valid
# API token
TOKEN = "ADD YOUR API TOKEN"

# login using the token to obtain a session ID
bApi = Client(BRONTO_WSDL)
# print bApi

try:
    session_id = bApi.service.login(TOKEN)
    print "logging in with sessionId: " + session_id
# Just exit if something goes wrong
except WebFault, e:
    print '\nERROR MESSAGE:'
    print e
    sys.exit()