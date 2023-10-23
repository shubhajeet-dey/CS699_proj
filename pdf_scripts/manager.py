#!/usr/bin/env python3
import base64
import json
import sys
from merge_pdf import merge_pdf
from split_pdf import split_pdf
from pdf_to_image import pdf_to_image
from rotate_pdf import rotate_pdf

if __name__ == "__main__":

	# Getting data as base64 encode json object (For issues with cmdline)
	content = json.loads(base64.b64decode(sys.argv[1]))

	try:
		if content["operation"] == "merge":
			print(merge_pdf(content["files"]))
			sys.exit(0)

		if content["operation"] == "split":
			print(split_pdf(content["file"], content["split_points"]))
			sys.exit(0)

		if content["operation"] == "pdf_to_image":
			print(pdf_to_image(content["file"], content["image_type"]))
			sys.exit(0)

		if content["operation"] == "rotate":
			print(rotate_pdf(content["file"], content["rotate_angle"]))
			sys.exit(0)

	except:
		print("Error: File Handling")