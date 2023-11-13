#!/usr/bin/env python3
from merge_pdf import merge_pdf
from split_pdf import split_pdf
from pdf_to_image import pdf_to_image
from rotate_pdf import rotate_pdf
from encrypt_pdf import encrypt_pdf
import base64
import json
import sys

if __name__ == "__main__":

	# Getting data as base64 encode json object (For issues with cmdline)
	content = json.loads(base64.b64decode(sys.argv[1]))

	try:
		if content["operation"] == "merge":
			print(merge_pdf(content["files"]))
		
		elif content["operation"] == "split":
			print(split_pdf(content["file"], content["split_points"]))

		elif content["operation"] == "pdf_to_image":
			print(pdf_to_image(content["file"], content["image_type"]))

		elif content["operation"] == "rotate":
			print(rotate_pdf(content["file"], content["rotate_angle"]))

		elif content["operation"] == "encrypt":
			print(encrypt_pdf(content["file"], content["password"], content["process_type"]))

	except:
		print("Error: File Handling")