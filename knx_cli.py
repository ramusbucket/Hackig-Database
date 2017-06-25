#!/usr/bin/python
import os,sys,requests
from colorama import init
init()

url = 'https://knx-db.com/'
OS = os.name

def cls():
    os.system('cls' if OS=='nt' else 'clear')
    
def banner():
    print col.BOLD + """
    --=[ ***************************************** ]=--
    --=[ **   KNX Command Database - V.4.0      ** ]=--
    --=[ **                                     ** ]=--
    --=[ **  Author: KNX - ddarix@gmail.com     ** ]=--
    --=[ **                                     ** ]=--
    --=[ ***************************************** ]=--\n\n
    """ +col.ENDC
   
class col:
    HEADER = '\033[95m' # viola
    OKBLUE = '\033[94m' # blu
    OKGREEN = '\033[92m' # verde
    WARNING = '\033[93m' # giallo
    FAIL = '\033[91m' # rosso
    ENDC = '\033[0m' # Reset
    BOLD = '\033[1m' # bianco acceso    

cls()
banner()

if len(sys.argv[1:]) == 0:    
    print col.WARNING + "Usage: %s <command_to_search>\n" %sys.argv[0] + col.ENDC
    sys.exit(1)

search = sys.argv[1]
payload = {'cerca': search, 'cli': 'true'}
r = requests.post(url, data=payload, allow_redirects=True)
print r.text 
    
