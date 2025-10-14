package internal

var EOLConstraints = []string{
	"^7",
	"^7.1",
	"^7.1.2",
	"^7.1.2 || ~8.0.3",
	"^7 <7.2.3",
	"7@stable",
}

var SupportedConstraints = []string{
	"^8",
	"^8.2",
	"^8.3.4",
	"^8.2 || ~8.4.0",
	"^8.2 <= 8.4.1",
	"^7.4 || ^8.4",
	">=7.4",
	"*",
	"@stable",
	"^8@rc",
}

var Modes = []string{
	"",
	"--mode=minor-only",
	"--mode=full",
}
