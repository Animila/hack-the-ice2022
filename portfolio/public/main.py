import re
from browser import document, console

textarea = document.getElementById('textarea')
text_html = document.getElementById('text-html')

def change_textarea(ev):
	html = MdToHtml(textarea.value).translate()
	text_html.innerHTML = html

textarea.bind("input", change_textarea)


class MdToHtml:
	def __init__(self, md_text):
		self.md_text = md_text.replace("\t", "    ") + '\n'
		self.i = 0
		self.vars = {}

	def get_char(self):
		if self.i < len(self.md_text):
			return self.md_text[self.i]
		else:
			return None

	def mult_next_char(self, n):
		start = self.i
		chars = []
		for i in range(n):
			chars.append(self.get_char())
			self.i += 1

		self.i = start
		return chars

	def is_HR(self):
		return re.match("^((\*){3,}|(\_){3,}|(\-){3,})[\t( )]*\n", self.md_text[self.i:])

	def is_Hn(self):
		return re.match("^(#){1,5}( ){1}", self.md_text[self.i:])

	def is_custom_tag(self):
		return self.get_char() == "^"

	def get_and_skip_line(self):
		line = ""
		char = self.get_char()
		while char != "\n":
			line += char
			self.i += 1
			char = self.get_char()

		self.i += 1

		return line

	def custom_tag(self):
		# !style HACK-THE-ICE-4.0
		# !script HACK-THE-ICE-4.0
		tags = {
			"!Logo-Event": "^<img src='mini-logo.png'>",
			"!Logo-MPIT": "^<img src='https://static.tildacdn.com/tild3165-6561-4239-b163-356465386632/Frame_14187_1.png'>",
			"!Logo-MPIT-mini": "^<img src='mpit-logo-mini.png'>",
			"!Logo-MPIT-large": "^<img src='mpit-logo-large.png'>",
		}

		lines = []

		for line in self.md_text.split("\n"):
			if line in tags.keys():
				line = tags[line]
			lines.append(line)

		self.md_text = "\n".join(lines)

	def translate(self):
		self.getVars()
		self.custom_tag()
		self.Link()
		char = self.get_char()
		s = ""
		while char != None:
			if self.is_empty_line():
				self.skip_line()
				char = self.get_char()
				continue
			elif self.is_custom_tag():
				s += self.get_and_skip_line()[1:]
			elif self.is_HR():
				s += "<hr>"
				self.skip_line()
				char = self.get_char()
				continue
			elif self.is_Hn():
				s += self.Hn()
			elif self.is_LI() or self.is_OL():
				s += self.List()
			elif self.is_blockquote():
				s += self.BlockQuote()
			elif self.is_code():
				s += self.Code()
			else:
				s += "<p>" + self.MnText() + "</p>"
			char = self.get_char()

		return s

	def skip_line(self):
		char = self.get_char()
		while char != None and char != "\n":
			self.i += 1
			char = self.get_char()
		self.i += 1

	def Hn(self):
		_cnt = 0
		chrs = self.mult_next_char(5)

		for c in chrs:
			if c != "#":
				break
			_cnt += 1

		s = ""

		self.i += _cnt + 1
		char = self.get_char()
		s = self.NewText()
		self.i += 1

		return f"<h{_cnt}>{s}</h{_cnt}>"

	def get_cnt_space(self):
		start = self.i

		sp = 0
		char = self.get_char()
		while char == " ":
			sp += 1
			self.i += 1
			char = self.get_char()

		self.i = start

		return sp

	def List(self, space_cnt=None):
		is_li = self.is_LI()
		if space_cnt is None:
			space_cnt = 0

			char = self.get_char()
			while char.isspace():
				space_cnt += 1
				self.i += 1
				char = self.get_char()

		sp = space_cnt
		if is_li:
			s = "<ul>"
		else:
			start = self.i
			number = ""
			char = self.get_char()
			while char.isdigit():
				number += char
				self.i += 1
				char = self.get_char()

			if not number:
				number = "1"
			s = "<ol start='" + number +  "'>"

			self.i = start

		while sp == space_cnt:
			if not (self.is_OL() or self.is_LI()):
				break

			if not is_li:
				char = self.get_char()
				while char.isdigit():
					self.i += 1
					char = self.get_char()
			self.i += 2  # skip (. ) or (- )
			s += "<li>" + self.NewText()
			self.i += 1  # skip (\n)
			sp = self.get_cnt_space()
			self.i += sp

			if (self.is_OL() or self.is_LI()):
				if sp > space_cnt:
					s += self.List(sp)
					sp = self.get_cnt_space()
					self.i += sp
				elif sp < space_cnt or (self.is_LI() and not is_li) or (self.is_OL() and is_li):
					s += "</li>"
					break

			s += "</li>"

		self.i -= sp

		if is_li:
			s = s + "</ul>"
		else:
			s = s + "</ol>"

		return s

	def Code(self):
		"""
		Только многострочный код
		"""
		char = self.get_char()

		s = "<pre><code>"

		self.get_and_skip_line()
		line = self.get_and_skip_line()
		while line != "```":
			s += line + "\n"
			line = self.get_and_skip_line()

		s += "</pre></code>"

		return s

	def BlockQuote(self):
		"""
		BlockQuote -> > MnText
					| > MnText (>)?
		"""

		s = "<blockquote>"
		temp_s = ""
		while True:
			cnt_space = self.get_cnt_space()
			self.i += cnt_space + 2

			if self.is_Hn():
				temp_s = self.Hn()
			else:
				temp_s = self.NewText() + "<br>"
				self.i += 1

			s += temp_s

			if not self.is_blockquote():
				break


		s += "</blockquote>"

		return s


	def is_empty_line(self):
		return re.match("^( )*\n", self.md_text[self.i:])

	def is_LI(self):
		return re.match("^( )*(\-|\+|\*)( ){1}", self.md_text[self.i:])

	def is_OL(self):
		return re.match("^( )*[0-9]+\.( ){1}", self.md_text[self.i:])

	def is_blockquote(self):
		return re.match("^( )*(\>)( )", self.md_text[self.i:])

	def is_code(self):
		return re.match("^`{3}\n", self.md_text[self.i:])  # (^( ){4,})|(^`{1,})

	def MnText(self):
		s = ""

		char = self.get_char()
		while char != None:
			s += self.NewText()

			self.i += 1
			char = self.get_char()
			if self.is_empty_line() or self.is_HR() or self.custom_tag() or self.is_Hn() or self.is_LI() or self.is_OL() or self.is_blockquote() or self.is_code():
				break

			# if self.is

		return s

	def is_var(self, line):
		return re.match("^( )*\[(\D|\d)*\]\:( )http(s)?\:\/\/[^ ]*(( )((\'(\D|\d)*\')|(\"(\D|\d)*\")))?$", line)  # [id]: https://asdflkas;dfl.com "asdfasdf"

	def getVars(self):
		"""

		[id]: URL 'подсказка'

		"""
		lst = []

		for line in self.md_text.split("\n"):
			if self.is_var(line):
				cnt_space = 0
				for char in line:
					if char != " ":
						break
					cnt_space += 1
				start, end = re.search("http(s)?\:\/\/[^ ]*", line).span()
				url = line[start:end]
				_id = line[1+cnt_space:start-3]
				help_text = line[end+2:-1]
				# {id: [URL, подсказка]}
				self.vars[_id] = [url, help_text]
			else:
				lst.append(line)

		self.md_text = "\n".join(lst)

	def Link(self):

		regexprs = [
			"\[([^\[\]])*\]\[(\D|\d)*\]",
			"\[([^\[\]])*\]\(http(s)?\:\/\/[^ ]*(( )(\'(\D|\d)*\')|(\"(\D|\d)*\"))?\)",
			"\<http(s)?\:\/\/[^ ]*\>"
		]

		lst = []

		new_s = ""

		for line in self.md_text.split("\n"):

			while True:
				for i in range(len(regexprs)):
					elem = re.search(regexprs[i], line)
					if not (elem is None):
						break

				if elem is None:
					break

				start, end = elem.span()
				el = line[start:end]

				is_img = re.search("http(s)?\:\/\/[^ ]*\.(jpg|png|gif|bmp){1}", el)  # jpg png gif bmp
				if i == 0:
					_, end_pos = re.search("\[([^\[\]])*\]", el).span()
					url, _ = self.vars[el[end_pos+1:-1]]
					text = el[1:end_pos-1]
					is_img = re.search("http(s)?\:\/\/[^ ]*\.(jpg|png|gif|bmp){1}", url)
				elif i == 1:
					_, end_pos = re.search("\[([^\[\]])*\]", el).span()
					text = el[1:end_pos-1]
					s, e = re.search("http(s)?\:\/\/[^ ]*\)", el).span()
					url = el[s:e-1]
				else:
					url = el[1:-1]
					text = url


				if is_img:
					line = line[:start] + f"<img src='{url}'>" + line[end:]
				else:
					line = line[:start] + f"<a href='{url}'>{text}</a>" + line[end:]


			lst.append(line)

		self.md_text = "\n".join(lst)


	def NewText(self):
		start = self.i

		s = ""

		# intermediate_representation
		is_a = False
		i_r = []
		string = ""
		char = self.get_char()
		while char != "\n" and char != None:
			self.i += 1
			next_char = self.get_char()
			self.i -= 1
			if char == "<":
				if next_char == "a":
					is_a = True
				elif next_char == "/":
					is_a = False

			if char in "_" and not is_a:
				if string:
					i_r.append(string)
					string = ""
				i_r.append(char)
				self.i += 1
				char = self.get_char()
				continue

			string += char
			self.i += 1
			char = self.get_char()

		if string:
			i_r.append(string)

		# self.i += 1

		# [i, i1, i2, ..., in]
		symbols = []

		# [tag_name, start, end(включительно)]
		vstavka = []

		i = 0
		while i < len(i_r):
			elem = i_r[i]
			next_elem = i_r[i + 1] if i + 1 < len(i_r) else ""

			if elem == "_":
				if not symbols:
					symbols.append(i)
				else:
					if symbols[-1] == i - 1:
						symbols.append(i)
					else:
						if len(symbols) >= 2 and next_elem == "_":
							i_r[symbols[-1]-1:symbols[-1]+1] = ["<strong>"]
							i_r[i-1:i+1] = ["</strong>"]
							symbols.pop()
							symbols.pop()
							i -= 1
						else:
							i_r[symbols[-1]] = "<em>"
							i_r[i] = "</em>"
							symbols.pop()
			elif not symbols:
				s += elem

			i += 1

		s = "".join(i_r)
		return s
