package internal

import (
	"os"
	"path/filepath"
)

type txtarWriter interface {
	Name() string
	Write(f *os.File) error
}

func Generate[T txtarWriter](name string, cases ...T) error {
	_, _ = os.Stdout.Write([]byte("\n==> Generating " + name + " scripts\n\n"))

	dir, err := filepath.Abs("testdata")
	if err != nil {
		return err
	}
	_, _ = os.Stdout.Write([]byte(dir + "\n"))

	if err := ensureDirEmpty(dir); err != nil {
		return err
	}

	for _, w := range cases {
		n := sanitizeFilename(w.Name()) + ".txtar"
		_, _ = os.Stdout.Write([]byte("  - " + n + "\n"))

		p := filepath.Join(dir, n)
		f, err := os.Create(p)
		if err != nil {
			return err
		}
		defer func() { _ = f.Close() }()

		err = w.Write(f)
		if err != nil {
			return err
		}
	}

	return nil
}
