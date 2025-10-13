package internal

var Constraints = []string{
	"^7",
	"^7.1",
	"^7.1.2",
	"^7.1.2 || ~8.1.2",
	"^7 ^7.2",
	"*",
	"@stable",
	"^7@stable",
}

var Modes = []string{
	"",
	"--mode=minor-only",
	"--mode=full",
}
