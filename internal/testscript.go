package internal

import (
	"os"
	"testing"

	"github.com/rogpeppe/go-internal/testscript"
)

func RunTestscript(t *testing.T) { //nolint:thelper
	testscript.Run(t, testscript.Params{
		Dir: "testdata",
		Setup: func(env *testscript.Env) error {
			// https://github.com/symfony/console/blob/4d889acb39a9b534b6adcf67771b098c860dd569/Style/SymfonyStyle.php#L47
			env.Setenv("COLUMNS", "120")
			return nil
		},
		UpdateScripts: os.Getenv("UPDATE_SCRIPTS") == "1",
	})
}
