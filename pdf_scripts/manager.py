#!/usr/bin/env python3
import base64
import json
import sys
from merge_pdf import merge_pdf
from split_pdf import split_pdf


if __name__ == "__main__":

	# Getting data as base64 encode json object (For issues with cmdline)
	content = json.loads(base64.b64decode(sys.argv[1]))

	try:
		if content["operation"] == "merge":
			print(merge_pdf(content["files"]))

		if content["operation"] == "split":
			print(split_pdf(content["file"], content["split_points"]))

	except:
		print("Error: File Handling")