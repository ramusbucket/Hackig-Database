<?php
include('header2.html');
?>

<div class="container-fluid" style="padding-bottom: 60px;">
    <div class="col-sm-10 col-sm-offset-1"><h4 style="color: black;">KNX Hacking Database can be easly scripted and used from command line.</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1"><p>With curl:</p>
      <p><pre><code>curl https://knx-db.com -d "cerca=[command to search]&cli=true"</code></pre></p>
    </div>
  </div>
  <div class="row">
	<br><br>
    <div class="col-sm-10 col-sm-offset-1"><p>With pyhton: <span class="pull-right">[ <a href="knx_cli.py" style="color: black;"> Download </a> ]</span></p>
      <p><pre><code>#!/usr/bin/python
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
print r.text</code></pre></p>
   </div>
  </div>
</div>
<?php
include('footer.html');
?>
