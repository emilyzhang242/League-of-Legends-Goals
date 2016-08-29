#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Created on Sun Mar 27 00:07:40 2016

@author: emilyzhang
"""

import urllib, json
import sys

#cgitb.enable()
#data = cgi.FieldStorage()

summoner = sys.argv[1]
year = sys.argv[2]
summ_id = sys.argv[3]


def get_matchlist(summ_id):
    
    global year
    
    request_name = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/"+str(summ_id)+"?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5&seasons=SEASON"+year+"&api_key=6a4fae8d-a82c-4fa6-b797-042dbdc2fa72"      
    name = json.loads(urllib.urlopen(request_name).read())
    info = name["matches"]
    matches = []

    for match in info:
        matches.append(match["matchId"])
    return matches


def main():

    matches = get_matchlist(summ_id)
    matches.sort()
    print len(matches)


if __name__ == '__main__':
    main()